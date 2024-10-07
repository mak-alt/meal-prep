<?php

namespace App\Http\Controllers\Frontend;

use App\Events\CheckoutCompleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Checkout\ApplyCouponRequest;
use App\Http\Requests\Frontend\Checkout\CalculateTotalPriceRequest;
use App\Http\Requests\Frontend\Checkout\PlaceOrderRequest;
use App\Http\Requests\Frontend\Checkout\RemoveCouponRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Page;
use App\Models\PaymentHistory;
use App\Models\PaymentLogs;
use App\Models\PaymentProfile;
use App\Models\Setting;
use App\Services\Payments\PayPalPaymentService;
//use App\Services\Payments\StripePaymentService;
use App\Services\SessionStorageHandlers\ShoppingCartSessionStorageService;
use Carbon\Carbon;
use CardDetect\Detector;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class CheckoutController extends Controller
{
    const DAYS_OF_WEEK = [
        '1' => '2',
        '2' => '3',
        '3' => '4',
        '4' => '5',
        '5' => '6',
        '6' => '7',
        '7' => '1'
    ];

    const REVERSE_DAYS = [
        '2' => 'monday',
        '3' => 'tuesday',
        '4' => 'wednesday',
        '5' => 'thursday',
        '6' => 'friday',
        '7' => 'saturday',
        '1' => 'sunday'
    ];

    public function index(Request $request)
    {
        $empty = ShoppingCartSessionStorageService::checkForEmpty();
        if ($empty){
            auth()->logout();
            session()->flush();
            setSessionResponseMessage('Something went wrong with storing your order, please log in and create your order again.','error');
            return redirect()->route('frontend.landing.index');
        }

        $shoppingCartOrders = ShoppingCartSessionStorageService::getMappedStoredData();
        $states = [
            'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY',
        ];
        if (
            !$request->ajax() &&
            (
                !session()->get(Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout']) ||
                $shoppingCartOrders->isEmpty() ||
                $shoppingCartOrders->pluck('selection_completed')->contains(false)
            )
        ) {
            session()->forget(Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout']);

            return redirect()->route('frontend.shopping-cart.index');
        }

        $user = auth()->user()->load(['profile', 'paymentProfiles']);

        $checkoutData               = Order::getCheckoutDataFromSession();
        $deliveryPickupLocationData = optional(Page::where('name', 'deliveryAndPickup')->first())->data;
        $deliveryPrice = optional(Setting::key('delivery')->first())->data;

        if ($request->filled('is_within_perimeter_of_i_285')) {
            $deliveryFees = $request->get('is_within_perimeter_of_i_285') === 'true'
                ? $deliveryPrice['within_i_285']
                : $deliveryPrice['outside_i_285'];
        } else {
            $deliveryFees = null;
        }

        $orderPriceWithoutDiscounts        = $shoppingCartOrders->sum('total_price') + $deliveryFees;
        $applicablePointsDiscount          = Order::getApplicablePointsDiscount($user, $orderPriceWithoutDiscounts);
        $applicableGiftsDiscount           = Order::getApplicableGiftsDiscount(
            $user,
            $orderPriceWithoutDiscounts,
            [$applicablePointsDiscount]
        );
        $referralFirstOrderDiscount        = Order::getReferralFirstOrderDiscount($user);
        $applicableReferralInviterDiscount = Order::getApplicableReferralInviterDiscount(
            $user,
            $orderPriceWithoutDiscounts,
            [$applicablePointsDiscount, $applicableGiftsDiscount, $referralFirstOrderDiscount]
        );
        $totalPriceWithDiscounts           = $orderPriceWithoutDiscounts -
            $applicablePointsDiscount -
            $applicableGiftsDiscount -
            $referralFirstOrderDiscount -
            $applicableReferralInviterDiscount;
        $userCouponsExists                 = $user->coupons()
            ->whereDate('start_date', '<=', today()->format('Y-m-d'))
            ->whereDate('expiration_date', '>', today()->format('Y-m-d'))
            ->exists();

        $page = Page::where('name', 'deliveryAndPickup')->first();

        $deliveryTimes = optional(Setting::key('delivery_times')->first())->data ?? [];
        $pickupTimes = optional(Setting::key('pickup_times')->first())->data ?? [];
        $pickupTimesB = optional(Setting::key('pickup_times_brookhaven')->first())->data ?? [];

        //dd($deliveryTimes, $pickupTimes, $pickupTimesB);

        $today = today()->format('N');

        $week = self::DAYS_OF_WEEK;

        $min = 10;
        $deliveryTime = [];
        $deliveryAvailableDays = [];
        foreach ($deliveryTimes as $info) {
            $time = Carbon::parse($info['time']);
            if (($info['day'] === $today && today() < $time)){
                $deliveryAvailableDays = [];
                foreach ($info['days_available'] as $day){
                    $deliveryAvailableDays[] = (int)$day['day'];
                    $deliveryTime[(int)$day['day']] = $day['times'];
                }
            }
            else{
                $count = abs($info['day'] - $today);
                if ($min > $count){
                    $min = $count;
                    $deliveryAvailableDays = [];
                    foreach ($info['days_available'] as $day){
                        $deliveryAvailableDays[] = (int)$day['day'];
                        $deliveryTime[(int)$day['day']] = $day['times'];
                    }
                }
            }
        }
        $nextDay = self::REVERSE_DAYS[min($deliveryAvailableDays)];
        $closestDay = new Carbon('next '.$nextDay);
        $closestDay = $closestDay->format('m/d/Y');
        $deliveryTime = $deliveryTime[min($deliveryAvailableDays)];

        $min = 10;
        $pickupTime = [];
        $pickupAvailableDays = [];
        foreach ($pickupTimes as $info) {
            $time = Carbon::parse($info['time']);
            if (($info['day'] === $today && today() < $time)){
                $pickupAvailableDays = [];
                foreach ($info['days_available'] as $day){
                    $pickupAvailableDays[] = (int)$day['day'];
                    $pickupTime[(int)$day['day']] = $day['times'];
                }
            }
            else{
                $count = abs($info['day'] - $today);
                if ($min > $count){
                    $min = $count;
                    $pickupAvailableDays = [];
                    foreach ($info['days_available'] as $day){
                        $pickupAvailableDays[] = (int)$day['day'];
                        $pickupTime[(int)$day['day']] = $day['times'];
                    }
                }
            }
        }
        $pickupTime = $pickupTime[min($pickupAvailableDays)];

        $min = 10;
        $pickupTimeB = [];
        $pickupBAvailableDays = [];
        foreach ($pickupTimesB as $info) {
            $time = Carbon::parse($info['time']);
            if (($info['day'] === $today && today() < $time)){
                $pickupBAvailableDays = [];
                foreach ($info['days_available'] as $day){
                    $pickupBAvailableDays[] = (int)$day['day'];
                    $pickupTimeB[(int)$day['day']] = $day['times'];
                }
            }
            else{
                $count = abs($info['day'] - $today);
                if ($min > $count){
                    $min = $count;
                    $pickupBAvailableDays = [];
                    foreach ($info['days_available'] as $day){
                        $pickupBAvailableDays[] = (int)$day['day'];
                        $pickupTimeB[(int)$day['day']] = $day['times'];
                    }
                }
            }
        }
        $pickupTimeB = $pickupTimeB[min($pickupBAvailableDays)];

        $allDays = [1,2,3,4,5,6,7];
        if ($request->ajax() && $request->type){
            $notAvailable = [];
            if ($request->type === 'delivery'){
                $nextDay = self::REVERSE_DAYS[min($deliveryAvailableDays)];
                $closestDay = new Carbon('next '.$nextDay);
                $closestDay = $closestDay->format('m/d/Y');
                $notAvailable = array_diff($allDays, $deliveryAvailableDays);
            }
            elseif ($request->type === 'decatur'){
                $nextDay = self::REVERSE_DAYS[min($pickupAvailableDays)];
                $closestDay = new Carbon('next '.$nextDay);
                $closestDay = $closestDay->format('m/d/Y');
                $notAvailable = array_diff($allDays, $pickupAvailableDays);
            }
            elseif ($request->type === 'brookhaven'){
                $nextDay = self::REVERSE_DAYS[min($pickupBAvailableDays)];
                $closestDay = new Carbon('next '.$nextDay);
                $closestDay = $closestDay->format('m/d/Y');
                $notAvailable = array_diff($allDays, $pickupBAvailableDays);
            }

            return  response()->json([
                'days' => $notAvailable,
                'closest_day' => $closestDay,
            ]);
        }

        return \view('frontend.checkout.index', compact(
            'shoppingCartOrders',
            'checkoutData',
            'user',
            'deliveryPickupLocationData',
            'applicableGiftsDiscount',
            'applicablePointsDiscount',
            'referralFirstOrderDiscount',
            'applicableReferralInviterDiscount',
            'totalPriceWithDiscounts',
            'deliveryFees',
            'userCouponsExists',
            'states',
            'closestDay',
            'page',
            'deliveryTime',
            'pickupTime',
            'pickupTimeB',
        ));
    }

    public function getTimeframesForWeekDay(Request $request)
    {
        $checkoutData = Order::getCheckoutDataFromSession();
        $week = self::DAYS_OF_WEEK;
        $dayOfWeek = Carbon::parse($request->day)->format("N");
        $dayOfWeek = $week[$dayOfWeek];
        $deliveryInfo = null;
        $type = null;
        $today = today()->format('N');
        //dd($today);
        if ($request->type === 'delivery'){
            $type = 'delivery';
            $deliveryInfo = optional(Setting::key('delivery_times')->first())->data ?? [];
        }
        elseif ($request->type === 'decatur'){
            $type = 'pickup';
            $deliveryInfo = optional(Setting::key('pickup_times')->first())->data ?? [];
        }
        elseif ($request->type === 'brookhaven'){
            $type = 'pickup';
            $deliveryInfo = optional(Setting::key('pickup_times_brookhaven')->first())->data ?? [];
        }

        $min = 10;
        $deliveryTime = [];
        foreach ($deliveryInfo as $info) {
            $time = Carbon::parse($info['time']);
            if (($info['day'] === $today && now() < $time)){
                foreach ($info['days_available'] as $day){
                    if ($day['day'] === $dayOfWeek){
                        $deliveryTime = $day['times'];
                    }
                }
            }
            else{
                $count = abs($info['day'] - $today);
                if ($min > $count){
                    $min = $count;
                    foreach ($info['days_available'] as $day){
                        if ($day['day'] === $dayOfWeek){
                            $deliveryTime = $day['times'];
                        }
                    }
                }
            }
        }

        $timeframes = view('frontend.checkout.inc.timeframe-element')->with([
            'checkoutData' => $checkoutData,
            'deliveryTime' => $deliveryTime,
            'type' => $type,
        ])->render();

        return response()->json([
            'timeframes' => $timeframes ?? null,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function proceedToCheckout(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                if (ShoppingCartSessionStorageService::getMappedStoredData()->isEmpty()) {
                    return response()->json($this->formatResponse('error', 'Your shopping cart is empty.'), 400);
                }

                if (ShoppingCartSessionStorageService::getMappedStoredData()->pluck('selection_completed')->contains(false)){
                    return response()->json($this->formatResponse('success', null, [
                        'redirect' => route('frontend.shopping-cart.index'),
                    ]));
                }

                session()->put(Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout'], true);

                return response()->json($this->formatResponse('success', null, [
                    'redirect' => route('frontend.checkout.index'),
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Proceeding to checkout failed'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Checkout\ApplyCouponRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyCoupon(ApplyCouponRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $coupon   = Coupon::where('coupon_code','like', "%$request->coupon_code%")->first();
                if ($coupon->users()->count() > 0 && !$coupon->users->contains(auth()->id())){
                    return response()->json($this->formatResponse('error', 'Applying coupon failed.'), 400);
                }
                if (auth()->user()->usedCoupons->pluck('coupon_id')->contains($coupon->id)){
                    return response()->json($this->formatResponse('error', 'The selected coupon code was already used once.'), 400);
                }
                $discount = $coupon->getDiscountCurrencyValue($request->total_price);

                return response()->json($this->formatResponse('success', null, [
                    'coupon_id'                        => $coupon->id,
                    'coupon_name'                      => $coupon->coupon_name,
                    'coupon_code'                      => $coupon->coupon_code,
                    'discount'                         => $discount,
                    'total_price_with_coupon_discount' => (float)($request->total_price - $discount) < 0 ? 0 :(float)($request->total_price - $discount),
                ]));
            } catch (\Throwable $exception) {
                // response()->json($this->formatResponse('error', 'Applying coupon failed'), 400);
                return response()->json($this->formatResponse('error', $exception->getMessage()), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Checkout\RemoveCouponRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCoupon(RemoveCouponRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $user               = auth()->user();
                $shoppingCartOrders = ShoppingCartSessionStorageService::getMappedStoredData();

                $deliveryPrice = optional(Setting::key('delivery')->first())->data;
                $z_i_p_codes = $deliveryPrice["zip_codes"] ?? [];
                $keyCode = array_search($request->search_address, array_column($z_i_p_codes, 'code'));
                if (!empty($z_i_p_codes) && ($keyCode !== false)) {
                    $deliveryFees = $z_i_p_codes[$keyCode]['price'];
                } elseif ($request->filled('is_within_perimeter_of_i_285')) {
                    $deliveryFees = $request->get('is_within_perimeter_of_i_285') === 'true'
                        ? $deliveryPrice['within_i_285']
                        : $deliveryPrice['outside_i_285'];
                } else {
                    $deliveryFees = null;
                }
                $orderPriceWithoutDiscounts = $shoppingCartOrders->sum('total_price') + $deliveryFees;
                $totalPriceWithDiscounts    = Order::calculateTotalPriceWithDiscounts(
                    $user,
                    $orderPriceWithoutDiscounts,
                );

                return response()->json($this->formatResponse('success', null, [
                    'total_price_without_coupon_discount' => $totalPriceWithDiscounts,
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Removing coupon failed'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Checkout\CalculateTotalPriceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateTotalPrice(CalculateTotalPriceRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $user               = auth()->user();
                $shoppingCartOrders = ShoppingCartSessionStorageService::getMappedStoredData();

                $deliveryPrice = optional(Setting::key('delivery')->first())->data;
                $z_i_p_codes = $deliveryPrice["zip_codes"] ?? [];
                $keyCode = array_search($request->search_address, array_column($z_i_p_codes, 'code'));
                if (!empty($z_i_p_codes) && ($keyCode !== false)) {
                    $deliveryFees = $z_i_p_codes[$keyCode]['price'];
                } elseif ($request->filled('is_within_perimeter_of_i_285')) {
                    $deliveryFees = $request->get('is_within_perimeter_of_i_285') === 'true'
                        ? $deliveryPrice['within_i_285']
                        : $deliveryPrice['outside_i_285'];
                } else {
                    $deliveryFees = null;
                }

                $orderPriceWithoutDiscounts = $shoppingCartOrders->sum('total_price') + $deliveryFees;
                $totalPriceWithDiscounts    = Order::calculateTotalPriceWithDiscounts(
                    $user,
                    $orderPriceWithoutDiscounts,
                    $request->coupon_id
                );
                $applicablePointsDiscount          = Order::getApplicablePointsDiscount($user, $orderPriceWithoutDiscounts);
                $applicableGiftsDiscount           = Order::getApplicableGiftsDiscount($user, $orderPriceWithoutDiscounts, [$applicablePointsDiscount]);
                $referralFirstOrderDiscount        = Order::getReferralFirstOrderDiscount($user);
                $applicableReferralInviterDiscount = Order::getApplicableReferralInviterDiscount(
                    $user,
                    $orderPriceWithoutDiscounts,
                    [$applicablePointsDiscount, $applicableGiftsDiscount, $referralFirstOrderDiscount]
                );
                $discounts = $orderPriceWithoutDiscounts
                    - $totalPriceWithDiscounts
                    - $applicablePointsDiscount
                    - $applicableGiftsDiscount
                    - $referralFirstOrderDiscount
                    - $applicableReferralInviterDiscount;

                return response()->json($this->formatResponse('success', null, [
                    'hide_delivery_price' => !$request->filled('is_within_perimeter_of_i_285'),
                    'delivery_price'      => $deliveryFees,
                    'total_price'         => $totalPriceWithDiscounts,
                    'discounts'           => $discounts,
                ]));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Calculating total order price failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Checkout\PlaceOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    private function pay_with_stripe($amount){
        
        // Stripe Payment Start
        $grand_total = $amount * 100;
        $successUrl = route('frontend.checkout.paypal.store-order-after-payment');
        $failedUrl = route('frontend.checkout.index');

        try {
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/checkout/sessions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "line_items[0][price_data][unit_amount]=".$grand_total."&
            line_items[0][price_data][product_data][name]=Payment for order&
            line_items[0][price_data][currency]=USD&
            line_items[0][quantity]=1&
            mode=payment&
            success_url=".$successUrl."&
            cancel_url=".$failedUrl);
            curl_setopt($ch, CURLOPT_USERPWD, env('DEV_STRIPE_SK') . ':' . '');

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
        }
        catch (exception $e) {
            dd($e->getMessage());
            die();
        }
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
       
        if($result) {

            $transaction_data=json_decode($result);   
            $data_array = (array) $transaction_data;
            $sessionId = $data_array['id'];

            return response()->json(
                $this->formatResponse(
                    'success',
                    'You can pay it now.',
                    ['redirect' => route('frontend.landing.stripe_payment_process', $sessionId)]
                )
            );
        }

        // Stripe Payment end
    }
    public function store(PlaceOrderRequest $request): JsonResponse
    {
        
        

        if ($request->ajax()) {
            try {
                if (!isset($request->pickup_location)){
                    $request->merge(['true_timeframe' => $request->delivery_time_frame]);
                }

                $shoppingCartOrders = ShoppingCartSessionStorageService::getMappedStoredData();
                if ($shoppingCartOrders->isEmpty()) {
                    return response()->json($this->formatResponse('error', 'Your shopping cart is empty.'), 400);
                }

                $user       = auth()->user();
                $chargeData = ['user' => $user, 'description' => 'Payment for order'];

                if ($request->filled(['card_number', 'expiration_month', 'expiration_year', 'csc'])) {
                    $chargeData = array_merge($chargeData, [
                        'card' => [
                            'number'        => $request->card_number,
                            'exp_month'     => $request->expiration_month,
                            'exp_year'      => $request->expiration_year,
                            'cvc'           => $request->csc,
                            'name_on_card'  => $request->name_on_card,
                        ],
                    ]);

                    /*if ($request->has('securely_save_to_account')) {
                        PaymentProfile::storePaymentMethod([
                            'card_number'      => $request->card_number,
                            'expiration_month' => $request->expiration_month,
                            'expiration_year'  => $request->expiration_year,
                            'csc'              => $request->csc,
                        ]);
                    }*/
                }
                if ($request->filled('payment_profile_id')) {
                    $chargeData['card_id'] = $user->paymentProfiles()
                        ->where('id', $request->payment_profile_id)
                        ->first()
                        ->stripe_card_id;
                }

                $deliveryPrice = optional(Setting::key('delivery')->first())->data;
                $z_i_p_codes = $deliveryPrice["zip_codes"] ?? [];
                $keyCode = array_search($request->delivery_zip, array_column($z_i_p_codes, 'code'));
                if (!empty($z_i_p_codes) && ($keyCode !== false)) {
                    $deliveryFees = $z_i_p_codes[$keyCode]['price'];
                } elseif ($request->filled('is_within_perimeter_of_i_285')) {
                    $deliveryFees = $request->get('is_within_perimeter_of_i_285') === 'true'
                        ? $deliveryPrice['within_i_285']
                        : $deliveryPrice['outside_i_285'];
                } else {
                    $deliveryFees = null;
                }

                $totalPriceWithoutDiscounts = $shoppingCartOrders->sum('total_price') + $deliveryFees;
                $totalPriceWithDiscounts    = Order::calculateTotalPriceWithDiscounts(
                    $user,
                    $totalPriceWithoutDiscounts,
                    $request->coupon_id
                );

                
                // Stripe Payment Start
                $grand_total = $totalPriceWithoutDiscounts * 100;
                $successUrl = route('frontend.checkout.paypal.store-order-after-payment');
                $failedUrl = route('frontend.checkout.index');

                try {
                    $ch = curl_init();
                    
                    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/checkout/sessions');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "line_items[0][price_data][unit_amount]=".$grand_total."&
                    line_items[0][price_data][product_data][name]=Payment for order&
                    line_items[0][price_data][currency]=USD&
                    line_items[0][quantity]=1&
                    mode=payment&
                    success_url=".$successUrl."&
                    cancel_url=".$failedUrl);
                    curl_setopt($ch, CURLOPT_USERPWD, env('DEV_STRIPE_SK') . ':' . '');

                    $headers = array();
                    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                }
                catch (exception $e) {
                    dd($e->getMessage());
                    die();
                }
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            
                if($result) {

                    $transaction_data=json_decode($result);   
                    $data_array = (array) $transaction_data;
                    $sessionId = $data_array['id'];

                    return response()->json(
                        $this->formatResponse(
                            'success',
                            'You can pay it now.',
                            ['redirect' => route('frontend.landing.stripe_payment_process', $sessionId)]
                        )
                    );
                }

                // Stripe Payment end
                
                

                $discounts = $totalPriceWithoutDiscounts - $totalPriceWithDiscounts;
                
                if ($totalPriceWithDiscounts >= 0 && $request->hasAny(['payment_profile_id', 'card_number'])) {
                    /*$chargeResponse = (new StripePaymentService())->makeSingleCharge($chargeData, $totalPriceWithDiscounts);

                    if (!$user->stripe_customer_id) {
                        $user->update(['stripe_customer_id' => $chargeResponse['customer']]);
                    }

                    if ($chargeResponse['status'] !== StripePaymentService::PAYMENT_SUCCESS_STATUS) {
                        return response()->json($this->formatResponse('error', 'Payment failed.'), 402);
                    }

                    $paymentHistory = PaymentHistory::storePayment([
                        'user_id'         => $user->id,
                        'payment_service' => PaymentHistory::PAYMENT_SERVICE_NAMES['stripe'],
                        'amount'          => $totalPriceWithDiscounts,
                        'transaction_id'  => $chargeResponse['id'],
                        'status'          => $chargeResponse['status'],
                        'card_last_4'     => $chargeResponse['payment_method_details']['card']['last4'],
                        'description'     => 'Payment for order',
                        'receipt_url'     => $chargeResponse['receipt_url'],
                        'created_at'      => Carbon::createFromTimestamp($chargeResponse['created']),
                    ]);*/
                    if ($totalPriceWithDiscounts > 0){
                        $detector = new Detector();
                        $paymentsCredentials = Setting::getPaymentServicesCredentials();
                        $type = strtolower($detector->detect($chargeData['card']['number']));
                        if ($type === 'amex') $type = 'american express';
                        if ($type === 'dinersclub') $type = 'diners club';



//                        $body = [
//                            'merchant_ref'          => 'AMP',
//                            'transaction_type'      => 'purchase',
//                            'method'                => 'credit_card',
//                            'amount'                => $totalPriceWithDiscounts*100 . '',
//                            'partial_redemption'    => 'false',
//                            'currency_code'         => 'USD',
//                            'credit_card' => [
//                                'type' => $type,
//                                'cardholder_name' => $user->first_name . ' ' . $user->last_name,
//                                'card_number' => $chargeData['card']['number'],
//                                'exp_date' => $chargeData['card']['exp_month'].$chargeData['card']['exp_year'],
//                                'cvv' => $chargeData['card']['cvc'],
//                            ]
//                        ];


/*Authorize*/

                        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                        $merchantAuthentication->setName($paymentsCredentials['merchant_login_id_key']);
                        $merchantAuthentication->setTransactionKey($paymentsCredentials['merchant_transaction_key']);

                        $refId = 'ref' . time();
                        $cardNumber = preg_replace('/\s+/', '', $chargeData['card']['number']);

                        $creditCard = new AnetAPI\CreditCardType();
                        $creditCard->setCardNumber($cardNumber);
                        $creditCard->setExpirationDate(20 . $chargeData['card']['exp_year'] . "-" . $chargeData['card']['exp_month']);
                        $creditCard->setCardCode($chargeData['card']['cvc']);

                        $paymentOne = new AnetAPI\PaymentType();
                        $paymentOne->setCreditCard($creditCard);

                        $transactionRequestType = new AnetAPI\TransactionRequestType();
                        $transactionRequestType->setTransactionType("authCaptureTransaction");
                        $transactionRequestType->setAmount($totalPriceWithDiscounts);
                        $transactionRequestType->setPayment($paymentOne);

                        $requests = new AnetAPI\CreateTransactionRequest();
                        $requests->setMerchantAuthentication($merchantAuthentication);
                        $requests->setRefId($refId);
                        $requests->setTransactionRequest($transactionRequestType);

                        $controller = new AnetController\CreateTransactionController($requests);
                        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

                        if ($response != null) {
                            if ($response->getMessages()->getResultCode() == "Ok") {
                                $tresponse = $response->getTransactionResponse();

                                if ($tresponse != null && $tresponse->getMessages() != null) {
                                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                                    $msg_type = "success";

                                    PaymentLogs::create([
                                        'amount' => $totalPriceWithDiscounts,
                                        'response_code' => $tresponse->getResponseCode(),
                                        'transaction_id' => $tresponse->getTransId(),
                                        'auth_id' => $tresponse->getAuthCode(),
                                        'message_code' => $tresponse->getMessages()[0]->getCode(),
                                        'name_on_card' => $chargeData['card']['name_on_card'],
                                        'quantity'=>1
                                    ]);
                                } else {
                                    $message_text = 'There were some issue with the payment. Please try again later.';
                                    $msg_type = "error";

                                    if ($tresponse->getErrors() != null) {
                                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                                        $msg_type = "error";
                                    }
                                }
                            } else {
                                $message_text = 'There were some issue with the payment. Please try again later.';
                                $msg_type = "error";

                                $tresponse = $response->getTransactionResponse();

                                if ($tresponse != null && $tresponse->getErrors() != null) {
                                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                                    $msg_type = "error";
                                } else {
                                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                                    $msg_type = "error";
                                }
                            }
                        } else {
                            $message_text = "No response returned";
                            $msg_type = "error";
                        }

                        if ($msg_type === 'error'){
                            return response()->json($this->formatResponse($msg_type, $message_text), 402);
                        }

                        $paymentHistory = PaymentHistory::storePayment([
                            'user_id'         => $user->id,
                            'payment_service' => PaymentHistory::PAYMENT_SERVICE_NAMES['authorize'],
                            'amount'          => $totalPriceWithDiscounts,
                            'transaction_id'  => $tresponse->getTransId(),
                            'status'          => $msg_type,
                            'card_last_4'     => $chargeData['card']['number'],
                            'description'     => 'Payment for order',
                            'receipt_url'     => null,
                            'created_at'      => now(),
                        ]);

/*Authorize End*/
                    }
                    else{
                        $paymentHistory = null;
                    }
                } else {
                    /*if($totalPriceWithDiscounts <= 0.5){
                        setSessionResponseMessage('Error! Payment failed. Total must be more than 0.50 $', 'error');
                        return response()->json($this->formatResponse('error', 'Error! Payment failed. Total must be more than 0.50 $.'), 400);
                    }*/

                    if ($totalPriceWithDiscounts > 0){
                        Order::storeCheckoutDataToSession($request->except(['_token', '_method']));

                        $chargeResponse = (new PayPalPaymentService())->prepareSingleCharge([
                            'description' => 'Payment for order',
                            'return_url'  => route('frontend.checkout.paypal.store-order-after-payment'),
                            'cancel_url'  => route('frontend.checkout.index'),
                        ], $totalPriceWithDiscounts);

                        return response()->json($this->formatResponse('success', null, [
                            'redirect' => $chargeResponse['redirect']->getTargetUrl(),
                        ]));
                    }
                    else{
                        $paymentHistory = null;
                    }
                }

                $order = DB::transaction(function () use (
                    $request,
                    $shoppingCartOrders,
                    $chargeData,
                    $user,
                    $deliveryFees,
                    $paymentHistory,
                    $totalPriceWithDiscounts,
                    $totalPriceWithoutDiscounts,
                    $discounts
                ) {
                    $applicablePointsDiscount   = Order::getApplicablePointsDiscount($user, $totalPriceWithoutDiscounts);
                    $applicableGiftsDiscount    = Order::getApplicableGiftsDiscount(
                        $user,
                        $totalPriceWithoutDiscounts,
                        [$applicablePointsDiscount]
                    );
                    $referralFirstOrderDiscount = Order::getReferralFirstOrderDiscount($user);

                    Order::usePointsDiscount($user, $totalPriceWithoutDiscounts);
                    Order::useGiftsDiscount($user, $totalPriceWithoutDiscounts, [$applicablePointsDiscount]);
                    Order::useReferralDiscount(
                        $user,
                        $totalPriceWithoutDiscounts,
                        [$applicablePointsDiscount, $applicableGiftsDiscount, $referralFirstOrderDiscount]
                    );

                    return Order::storeOrder(
                        array_merge(
                            $request->validated(),
                            [
                                'payment_history_id'            => $paymentHistory->id ?? null,
                                'total_price'                   => $totalPriceWithDiscounts,
                                'total_price_without_discounts' => $totalPriceWithoutDiscounts,
                                'total_points'                  => $totalPriceWithDiscounts*10,
                                'discounts'                     => $discounts,
                                'pickup_time_frame'             => $request->pickup_time_frame ?? null,
                                'true_timeframe'                => $request->true_timeframe ?? null,
                            ],
                        ),
                        $shoppingCartOrders
                    );
                });

                event( new CheckoutCompleted($order, $user->email, $user));

                return response()->json(
                    $this->formatResponse(
                        'success',
                        'Your order has been successfully placed.',
                        ['redirect' => route('frontend.orders.show', $order->id)]
                    )
                );
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Checkout failed.'), 400);
            }
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeOrderAfterPaypalPayment(Request $request): RedirectResponse
    {
        $shoppingCartOrders = ShoppingCartSessionStorageService::getMappedStoredData();
        if ($shoppingCartOrders->isEmpty()) {
            return redirect()->route('frontend.shopping-cart.index');
        }

        $user = auth()->user();
        $checkoutData               = Order::getCheckoutDataFromSession();
        if (isset($checkoutData['pickup_time_frame']) && $checkoutData['pickup_time_frame'] !== null){
            $deliveryFees = 0;
        }
        else{
            $deliveryPrice = optional(Setting::key('delivery')->first())->data;
            $z_i_p_codes = $deliveryPrice["zip_codes"] ?? [];
            $keyCode = array_search($checkoutData['delivery_zip'], array_column($z_i_p_codes, 'code'));
            if (!empty($z_i_p_codes) && ($keyCode !== false)) {
                $deliveryFees = $z_i_p_codes[$keyCode]['price'];
            } elseif (isset($checkoutData['is_within_perimeter_of_i_285'])) {
                $deliveryFees = $checkoutData['is_within_perimeter_of_i_285'] === 'true'
                    ? $deliveryPrice['within_i_285']
                    : $deliveryPrice['outside_i_285'];
            } else {
                $deliveryFees = null;
            }
        }
        $totalPriceWithoutDiscounts = $shoppingCartOrders->sum('total_price') + $deliveryFees;
        $totalPriceWithDiscounts    = Order::calculateTotalPriceWithDiscounts(
            $user,
            $totalPriceWithoutDiscounts,
            $request->coupon_id ?? $checkoutData['coupon_id']
        );
        $discounts = $totalPriceWithoutDiscounts - $totalPriceWithDiscounts;
        try {
            $chargeResponse = (new PayPalPaymentService())->executeSingleCharge(
                $request->paymentId,
                $request->PayerID,
                $request->token
            );

            if ($chargeResponse->getState() !== 'approved') {
                setSessionResponseMessage('Error! Payment failed.', 'error');

                return redirect()->route('frontend.checkout.index');
            }

            $paymentHistory = PaymentHistory::storePayment([
                'user_id'         => $user->id,
                'payment_service' => PaymentHistory::PAYMENT_SERVICE_NAMES['paypal'],
                'amount'          => $totalPriceWithDiscounts,
                'transaction_id'  => $chargeResponse->getId(),
                'status'          => $chargeResponse->getState(),
                'card_last_4'     => null,
                'description'     => 'Payment for order',
                'receipt_url'     => null,
                'created_at'      => Carbon::parse($chargeResponse->getCreateTime()),
            ]);

            $order = DB::transaction(function () use (
                $request,
                $shoppingCartOrders,
                $checkoutData,
                $user,
                $deliveryFees,
                $totalPriceWithDiscounts,
                $paymentHistory,
                $totalPriceWithoutDiscounts,
                $discounts
            ) {
                $applicablePointsDiscount   = Order::getApplicablePointsDiscount($user, $totalPriceWithoutDiscounts);
                $applicableGiftsDiscount    = Order::getApplicableGiftsDiscount(
                    $user,
                    $totalPriceWithoutDiscounts,
                    [$applicablePointsDiscount]
                );
                $referralFirstOrderDiscount = Order::getReferralFirstOrderDiscount($user);

                Order::usePointsDiscount($user, $totalPriceWithoutDiscounts);
                Order::useGiftsDiscount($user, $totalPriceWithoutDiscounts, [$applicablePointsDiscount]);
                Order::useReferralDiscount(
                    $user,
                    $totalPriceWithoutDiscounts,
                    [$applicablePointsDiscount, $applicableGiftsDiscount, $referralFirstOrderDiscount]
                );

                return Order::storeOrder(
                    array_merge(
                        $checkoutData,
                        [
                            'payment_history_id'            => $paymentHistory->id ?? null,
                            'total_price'                   => $totalPriceWithDiscounts,
                            'total_price_without_discounts' => $totalPriceWithoutDiscounts,
                            'total_points'                  => $totalPriceWithDiscounts * 10,
                            'discounts'                     => $discounts,
                        ],
                    ),
                    $shoppingCartOrders
                );
            });

            event( new CheckoutCompleted($order, $user->email, $user));

            return redirect()->route('frontend.orders.show', $order->id);
        } catch (\Throwable $exception) {
            setSessionResponseMessage('Error! Checkout failed.', 'error');

            return redirect()->route('frontend.checkout.index');
        }
    }


    public function stripe_payment_process($id){
        $timeframes = view('dummy.index')->with([
            'sessionId' => $id
        ])->render();

        return response()->json([
            'timeframes' => $timeframes ?? null,
        ]);

    }
}
