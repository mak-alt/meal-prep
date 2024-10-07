<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Profile\DeletePaymentMethodRequest;
use App\Http\Requests\Frontend\Profile\StorePaymentMethodRequest;
use App\Http\Requests\Frontend\Profile\UpdateBillingAddressRequest;
use App\Http\Requests\Frontend\Profile\UpdateDeliveryAddressRequest;
use App\Http\Requests\Frontend\Profile\UpdateEmailRequest;
use App\Http\Requests\Frontend\Profile\UpdatePasswordRequest;
use App\Http\Requests\Frontend\Profile\UpdatePersonalDetailsRequest;
use App\Models\PaymentProfile;
use App\Models\Profile;
use App\Models\VerificationCode;
use App\Notifications\Profile\UpdateEmailVerificationCodeSent;
use App\Services\Payments\StripePaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $states = [
            'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY',
        ];
        $user = auth()->user()->load(['profile', 'paymentProfiles']);
        if ($user->first_name === null && $user->last_name === null){
            setSessionResponseMessage('Please fill your first and last name fields, or you won`t be able to use our site correctly!', 'error');
        }
        return \view('frontend.profile.index', compact('user', 'states'));
    }

    /**
     * @param \App\Http\Requests\Frontend\Profile\UpdatePersonalDetailsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePersonalDetails(UpdatePersonalDetailsRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                DB::transaction(function () use ($request) {
                    Profile::updateOrCreatePersonalDetails($request->validated());
                });

                return response()->json($this->formatResponse('success', 'Personal details has been successfully updated.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Personal details update failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Profile\UpdateEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail(UpdateEmailRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $user = auth()->user();

                if ($request->has('email') && $request->has('password')) {
                    DB::transaction(function () use ($user, $request) {
                        $verificationCode = VerificationCode::storeRandomVerificationCode();
                        $user->notify(new UpdateEmailVerificationCodeSent($verificationCode->code));
                    });

                    session()->put('new-email', $request->email);

                    return response()->json($this->formatResponse('success'));
                }

                if ($request->has('code')) {
                    $newEmail = session()->get('new-email');

                    if (empty($newEmail)) {
                        return response()->json($this->formatResponse('error', 'Not all data has been filled in.'), 400);
                    }

                    DB::transaction(function () use ($user, $newEmail) {
                        $user->updateEmail($newEmail);
                    });

                    session()->forget('new-email');

                    return response()->json(
                        $this->formatResponse(
                            'success',
                            'Email address has been successfully changed. Don\'t forget to use it next time you login.',
                            ['email' => $newEmail]
                        )
                    );
                }
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Email update failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Profile\UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                auth()->user()->updatePassword($request->password);

                return response()->json(
                    $this->formatResponse(
                        'success',
                        'Password has been successfully updated. Don\'t forget to use it next time you login.',
                    )
                );
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Password update failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Profile\UpdateDeliveryAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDeliveryAddress(UpdateDeliveryAddressRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                DB::transaction(function () use ($request) {
                    Profile::updateOrCreateDeliveryAddress($request->validated());
                });

                return response()->json(
                    $this->formatResponse(
                        'success',
                        'Delivery address has been successfully updated.',
                        [
                            'delivery_address'       => "$request->delivery_zip, $request->delivery_country, $request->delivery_state, $request->delivery_city, $request->delivery_street_address, $request->billing_address_opt",
                            'update_billing_address' => $request->has('delivery_use_address_as_billing_address'),
                            'billing_zip'            => $request->delivery_zip,
                            'billing_state'          => $request->delivery_state,
                            'billing_city'           => $request->delivery_city,
                            'billing_street_address' => $request->delivery_street_address,
                            'billing_address_opt'    => $request->delivery_address_opt,
                            'billing_company_name'   => $request->delivery_company_name,
                            'billing_phone_number'   => $request->delivery_phone_number,
                        ]
                    )
                );

            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Delivery address update failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Profile\UpdateBillingAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBillingAddress(UpdateBillingAddressRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                DB::transaction(function () use ($request) {
                    Profile::updateOrCreateBillingAddress($request->validated());
                });

                return response()->json(
                    $this->formatResponse(
                        'success',
                        'Billing address has been successfully updated.',
                        [
                            'billing_address'         => "$request->billing_zip, $request->billing_country, $request->billing_state, $request->billing_city, $request->billing_street_address, $request->billing_address_opt",
                            'update_delivery_address' => $request->has('billing_use_address_as_delivery_address'),
                            'delivery_zip'            => $request->billing_zip,
                            'delivery_state'          => $request->billing_state,
                            'delivery_city'           => $request->billing_city,
                            'delivery_street_address' => $request->billing_street_address,
                            'delivery_address_opt'    => $request->billing_address_opt,
                            'delivery_company_name'   => $request->billing_company_name,
                            'delivery_phone_number'   => $request->billing_phone_number,
                        ]
                    )
                );
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Billing address update failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Profile\StorePaymentMethodRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePaymentMethod(StorePaymentMethodRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $paymentProfile = PaymentProfile::storePaymentMethod($request->validated());
                $showLabel      = auth()->user()->paymentProfiles()->count() === 1;

                return response()->json(
                    $this->formatResponse(
                        'success',
                        'Payment method has been successfully created.',
                        [
                            'payment_method_view' => \view('frontend.profile.partials.popups.payment-method-item', compact('paymentProfile', 'showLabel'))
                                ->render(),
                        ]
                    )
                );
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Payment method creation failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Profile\DeletePaymentMethodRequest $request
     * @param \App\Models\PaymentProfile $paymentProfile
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPaymentMethod(DeletePaymentMethodRequest $request, PaymentProfile $paymentProfile): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $paymentProfile->deletePaymentMethod();

                return response()->json($this->formatResponse('success', 'Payment method has been successfully deleted.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Payment method deletion failed.'), 400);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDefaultDeliveryAddress(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $user = auth()->user()->load('profile');

            return response()->json($this->formatResponse('success', null, [
                'delivery_country'        => optional($user->profile)->delivery_country,
                'delivery_state'          => optional($user->profile)->delivery_state,
                'delivery_city'           => optional($user->profile)->delivery_city,
                'delivery_street_address' => optional($user->profile)->delivery_street_address,
                'delivery_address_opt'    => optional($user->profile)->delivery_address_opt,
                'delivery_zip'            => optional($user->profile)->delivery_zip,
                'delivery_company_name'   => optional($user->profile)->delivery_company_name,
                'delivery_phone_number'   => optional($user->profile)->delivery_phone_number,
            ]));
        }
    }
}
