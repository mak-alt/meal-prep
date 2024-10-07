<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Order extends Model
{
    use HasFactory;

    public const TIME_FRAMES = [
        'morning' => 'morning',
        'lunch'   => 'lunch',
        'evening' => 'evening',
    ];

    public const TIME_FRAME_MAPPING = [
        self::TIME_FRAMES['morning'] => '8:00 AM - 12:30 PM',
        self::TIME_FRAMES['lunch']   => '1:00 PM - 4:30 PM',
        self::TIME_FRAMES['evening'] => '4:30 PM - 9:00 PM',
    ];

    public const STATUSES = [
        'upcoming'  => 'upcoming',
        'completed' => 'completed',
        'failed'    => 'failed',
    ];

    public const ONBOARDING_SESSION_KEYS = [
        'free_meals_selection'           => 'free-meals-selection',
        'preferred_menu_type_selection'  => 'preferred-menu-type-selection',
        'amount_of_meals_selection'      => 'amount-of-meals-selection',
        'meal_creation_step_validated'   => 'meal_creation_step_validated',
        'meal_creation_step_has_warning' => 'meal_creation_step_has_warning',
        'current_meal_selection_uuid'    => 'current-meal-selection-uuid',
        'proceeded_to_checkout'          => 'proceeded-to-checkout',
        'checkout_data'                  => 'checkout-data',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'status',
        'payment_history_id',
        'total_price',
        'total_price_without_discounts',
        'total_points',
        'receiver_first_name',
        'receiver_last_name',
        'receiver_email',
        'receiver_company_name',
        'delivery_date',
        'delivery_time_frame',
        'delivery_country',
        'delivery_state',
        'delivery_city',
        'delivery_street_address',
        'delivery_address_opt',
        'delivery_zip',
        'delivery_company_name',
        'delivery_phone_number',
        'delivery_order_notes',
        'pickup_date',
        'pickup_time_frame',
        'pickup_location',
        'billing_country',
        'billing_state',
        'billing_city',
        'billing_street_address',
        'billing_address_opt',
        'billing_zip',
        'billing_company_name',
        'billing_phone_number',
        'billing_email_address',
        'discounts',
        'true_timeframe',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'delivery_date' => 'date',
        'pickup_date'   => 'date',
    ];

    /**
     * @param string $value
     */
    public function setReceiverFirstNameAttribute(string $value): void
    {
        $this->attributes['receiver_first_name'] = ucfirst($value);
    }

    /**
     * @param string $value
     */
    public function setReceiverLastNameAttribute(string $value): void
    {
        $this->attributes['receiver_last_name'] = ucfirst($value);
    }

    /**
     * @return string|null
     */
    public function getFullDeliveryAddressAttribute(): ?string
    {
        if ($this->pickup_location) {
            return null;
        }

        return "$this->delivery_zip, $this->delivery_country, $this->delivery_state, $this->delivery_city, $this->delivery_street_address";
    }

    /**
     * @return string|null
     */
    public function getDeliveryTimeFrameValueAttribute(): ?string
    {
        if ($this->true_timeframe !== null){
            return $this->true_timeframe;
        }
        else{
            return self::TIME_FRAME_MAPPING[$this->delivery_time_frame] ?? null;
        }
    }

    /**
     * @return string|null
     */
    public function getPickupTimeFrameValueAttribute(): ?string
    {
        return $this->pickup_time_frame ?? '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentHistory(): BelongsTo
    {
        return $this->belongsTo(PaymentHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return bool
     */
    public function hasDeliveryOption(): bool
    {
        return empty($this->pickup_location);
    }

    /**
     * @return bool
     */
    public function hasPickupOption(): bool
    {
        return !empty($this->pickup_location);
    }

    /**
     * @param array $data
     * @param \Illuminate\Support\Collection $shoppingCartOrders
     * @return static|null
     */
    public static function storeOrder(array $data, Collection $shoppingCartOrders): ?self
    {
        //dd($data, $shoppingCartOrders);
        $user = auth()->user();
        $order = self::create([
            'user_id'                       => $user->id,
            'payment_history_id'            => $data['payment_history_id'],
            'total_price'                   => $data['total_price'],
            'total_price_without_discounts' => $data['total_price_without_discounts'],
            'total_points'                  => $data['total_points'],
            'receiver_first_name'           => $user->first_name ?? '',//$data['receiver']['first_name'],
            'receiver_last_name'            => $user->last_name ?? '',//$data['receiver']['last_name'],
            'receiver_email'                => $user->email,//$data['receiver']['email'],
            'receiver_company_name'         => optional($user->profile)->delivery_company_name ?? '',//$data['receiver']['company_name'],
            'delivery_date'                 => !empty($data['delivery_date'])
                ? Carbon::createFromFormat('m/d/Y', $data['delivery_date'])
                : null,
            'delivery_time_frame'           => $data['delivery_time_frame'] ?? null,
            'delivery_country'              => 'United States (US)',
            'delivery_state'                => $data['delivery_state'] ?? null,
            'delivery_city'                 => $data['delivery_city'] ?? null,
            'delivery_street_address'       => $data['delivery_street_address'] ?? null,
            'delivery_address_opt'          => $data['delivery_address_opt'] ?? null,
            'delivery_zip'                  => $data['delivery_zip'] ?? null,
            'delivery_company_name'         => $data['delivery_company_name'] ?? null,
            'delivery_phone_number'         => $data['delivery_phone_number'] ?? null,
            'delivery_order_notes'          => $data['delivery_order_notes'] ?? null,
            'billing_country'               => 'United States (US)',
            'billing_state'                 => $data['billing_state'] ?? null,
            'billing_city'                  => $data['billing_city'] ?? null,
            'billing_street_address'        => $data['billing_street_address'] ?? null,
            'billing_address_opt'           => $data['billing_address_opt'] ?? null,
            'billing_zip'                   => $data['billing_zip'] ?? null,
            'billing_company_name'          => $data['billing_company_name'] ?? null,
            'billing_phone_number'          => $data['billing_phone_number'] ?? null,
            'billing_email_address'         => $data['billing_email_address'] ?? null,
            'pickup_date'                   => !empty($data['pickup_date'])
                ? Carbon::createFromFormat('m/d/Y', $data['pickup_date'])
                : null,
            'pickup_time_frame'             => $data['pickup_time_frame'] ?? null,
            'pickup_location'               => $data['pickup_location'] ?? null,
            'discounts'                     => $data['discounts'] ?? null,
            'true_timeframe'                => $data['true_timeframe'] ?? null,
        ]);

        foreach ($shoppingCartOrders as $shoppingCartOrder) {
            $orderItem = OrderItem::storeOrderItem([
                'order_id'     => $order->id,
                'menu_id'      => $shoppingCartOrder['menu_id'],
                'menu'         => $shoppingCartOrder['menu'],
                'items_amount' => $shoppingCartOrder['meals_amount'],
                'total_price'  => $shoppingCartOrder['total_price'],
                'portion_size' => (int)$shoppingCartOrder['portion_size']['size'] ?? null,
            ]);
            $orderItem->storeOrderItemItemables($shoppingCartOrder);
        }

        if (isset($data['coupon_id']) && $data['coupon_id'] !== null){
            $used = UsedCoupon::where([
                ['user_id', auth()->id()],
                ['coupon_id', $data['coupon_id']]
            ])->first();
            if (!$used){
                UsedCoupon::create([
                    'user_id' => auth()->id(),
                    'coupon_id' => $data['coupon_id'],
                ]);
            }
        }

        return $order;
    }

    /**
     * @param \App\Models\User $user
     * @param int $orderPriceWithoutDiscounts
     * @return int
     */
    public static function getApplicablePointsDiscount(User $user, int $orderPriceWithoutDiscounts): int
    {
        $pointsDiscount = $user->getPointsDiscount();

        return $pointsDiscount >= $orderPriceWithoutDiscounts ? $orderPriceWithoutDiscounts : $pointsDiscount;
    }

    /**
     * @param \App\Models\User $user
     * @param int $orderTotalPrice
     * @param array $discountsApplied
     * @return int
     */
    public static function getApplicableGiftsDiscount(User $user, int $orderTotalPrice, array $discountsApplied): int
    {
        $giftsDiscount        = $user->getGiftsDiscount();
        $discountsAppliedCost = collect($discountsApplied)->sum();

        if ($orderTotalPrice - $discountsAppliedCost === 0) {
            return 0;
        }

        return $giftsDiscount >= $orderTotalPrice - $discountsAppliedCost
            ? $orderTotalPrice - $discountsAppliedCost
            : $giftsDiscount;
    }

    /**
     * @param \App\Models\User $user
     * @param int $orderTotalPrice
     * @param array $discountsApplied
     * @return int
     */
    public static function getApplicableReferralInviterDiscount(User $user, int $orderTotalPrice, array $discountsApplied): int
    {
        $referralInviterDiscount = $user->getReferralInviterDiscount();
        $discountsAppliedCost    = collect($discountsApplied)->sum();

        if ($orderTotalPrice - $discountsAppliedCost === 0) {
            return 0;
        }

        return $referralInviterDiscount >= $orderTotalPrice - $discountsAppliedCost
            ? $orderTotalPrice - $discountsAppliedCost
            : $referralInviterDiscount;
    }

    /**
     * @param \App\Models\User $user
     * @return int
     */
    public static function getReferralFirstOrderDiscount(User $user): int
    {
        return $user->hasReferralFirstOrderDiscount() ? Setting::key('amountInviteeGets')->first()->data : 0;
    }

    /**
     * @param \App\Models\User $user
     * @param int $orderPriceWithoutDiscounts
     * @return bool
     */
    public static function usePointsDiscount(User $user, int $orderPriceWithoutDiscounts): bool
    {
        $unusedPoints        = $user->userReward->unused_points ?? 0;
        $pointsDiscountCount = $unusedPoints / 5000 >= 1
            ? round($unusedPoints / 5000, 0, PHP_ROUND_HALF_DOWN)
            : 0;
        $pointsUsed          = $pointsDiscountCount * 5000;
        $pointsDiscount      = $pointsDiscountCount * 10;

        if ($orderPriceWithoutDiscounts >= $pointsDiscount) {
            $user->userReward()->increment('used_points', $pointsUsed);
        } else {
            $user->userReward()->increment(
                'used_points',
                round(($orderPriceWithoutDiscounts - $pointsDiscount) / 10, 0, PHP_ROUND_HALF_DOWN) * 5000
            );
        }

        return true;
    }

    /**
     * @param \App\Models\User $user
     * @param int $orderTotalPrice
     * @param array $discountsApplied
     * @return bool
     */
    public static function useGiftsDiscount(User $user, int $orderTotalPrice, array $discountsApplied): bool
    {
        $unusedGifts = $user->gifts()
            ->whereNotNull('redeemed_at')
            ->whereNull('used_at')
            ->get();

        $discounts = collect($discountsApplied);

        foreach ($unusedGifts as $unusedGift) {
            $discount                     = $discounts->sum();
            $orderTotalPriceWithDiscounts = $orderTotalPrice - $discount;

            if ($orderTotalPriceWithDiscounts > 0) {
                if ($orderTotalPriceWithDiscounts >= $unusedGift->unused_amount) {
                    $unusedGift->update(['used_at' => now(), 'used_amount' => $unusedGift->amount]);
                    $discounts->push($unusedGift->amount);
                } else {
                    $unusedGift->increment('used_amount', $orderTotalPriceWithDiscounts);
                    $discounts->push($orderTotalPriceWithDiscounts);
                }
            } else {
                break;
            }
        }

        return true;
    }

    /**
     * @param \App\Models\User $user
     * @param int $orderTotalPrice
     * @param array $discountsApplied
     * @return bool
     */
    public static function useReferralDiscount(User $user, int $orderTotalPrice, array $discountsApplied): bool
    {
        $unusedReferralUserBonus = $user->referralUser()
            ->where('status', Referral::STATUSES['pending'])
            ->whereNull('user_first_order_at')
            ->first();

        if ($unusedReferralUserBonus) {
            UserReward::accrueReward($unusedReferralUserBonus->inviter_id, 100);

            $unusedReferralUserBonus->update([
                'status'              => Referral::STATUSES['active'],
                'user_first_order_at' => now(),
            ]);
        }

        $unusedReferralInviterBonuses = $user->referrals()
            ->where('status', Referral::STATUSES['active'])
            ->whereNotNull('user_first_order_at')
            ->whereColumn('inviter_money_gained', '>', 'inviter_money_spent')
            ->get();

        $discounts = collect($discountsApplied);

        foreach ($unusedReferralInviterBonuses as $unusedReferralInviterBonus) {
            $discounts->push($unusedReferralInviterBonus->getUnusedInviterMoney());
            $discount                     = $discounts->sum();
            $orderTotalPriceWithDiscounts = $orderTotalPrice - $discount;

            if ($orderTotalPriceWithDiscounts >= $unusedReferralInviterBonus->getUnusedInviterMoney()) {
                $unusedReferralInviterBonus->update(['inviter_money_spent' => $unusedReferralInviterBonus->getUnusedInviterMoney()]);
            } else {
                $unusedReferralInviterBonus->increment('inviter_money_spent', $unusedReferralInviterBonus->getUnusedInviterMoney());
            }
        }

        return true;
    }

    /**
     * @param \App\Models\User $user
     * @param int $priceWithoutDiscounts
     * @param int|null $couponId
     * @return int
     */
    public static function calculateTotalPriceWithDiscounts(User $user, $priceWithoutDiscounts, int $couponId = null)
    {
        if ($couponId) {
            $coupon = Coupon::find($couponId);

            if ($coupon->users()->count() > 0 && !$coupon->users->contains(auth()->id())){
                $coupon = null;
            }
        }

        $applicablePointsDiscount          = Order::getApplicablePointsDiscount($user, $priceWithoutDiscounts);
        $applicableGiftsDiscount           = Order::getApplicableGiftsDiscount($user, $priceWithoutDiscounts, [$applicablePointsDiscount]);
        $referralFirstOrderDiscount        = Order::getReferralFirstOrderDiscount($user);
        $applicableReferralInviterDiscount = Order::getApplicableReferralInviterDiscount(
            $user,
            $priceWithoutDiscounts,
            [$applicablePointsDiscount, $applicableGiftsDiscount, $referralFirstOrderDiscount]
        );

        $totalPriceWithDiscounts = $priceWithoutDiscounts -
            $applicablePointsDiscount -
            $applicableGiftsDiscount -
            $referralFirstOrderDiscount -
            $applicableReferralInviterDiscount;

        if (!empty($coupon)) {
            $totalPriceWithDiscounts -= $coupon->getDiscountCurrencyValue($totalPriceWithDiscounts);
        }

        return $totalPriceWithDiscounts >= 0 ? $totalPriceWithDiscounts : 0;
    }

    /**
     * @param array $requestData
     * @return bool
     */
    public static function storeCheckoutDataToSession(array $requestData): bool
    {
        session()->put(self::ONBOARDING_SESSION_KEYS['checkout_data'], $requestData);

        return true;
    }

    /**
     * @return array
     */
    public static function getCheckoutDataFromSession(): array
    {
        return session()->get(self::ONBOARDING_SESSION_KEYS['checkout_data'], []);
    }
}
