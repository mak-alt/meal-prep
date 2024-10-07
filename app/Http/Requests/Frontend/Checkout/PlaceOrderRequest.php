<?php

namespace App\Http\Requests\Frontend\Checkout;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Page;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCustomer();
    }

    public function prepareForValidation(): void
    {
        if ($this->has(['card_number', 'expiration'])) {
            $cardExpirationChunks = explode('/', $this->expiration);

            $this->merge([
                'card_number'      => str_replace(' ', '', $this->card_number),
                'expiration_month' => $cardExpirationChunks[0] ?? null,
                'expiration_year'  => $cardExpirationChunks[1] ?? null,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $pickupLocations = collect(
            optional(Page::where('name', 'deliveryAndPickup')->first())->data['pickup_locations']['items'] ?? []
        )->pluck('address')->toArray();

        return [
//            'receiver.first_name'         => ['nullable', 'string', 'max:255'],
//            'receiver.last_name'          => ['nullable', 'string', 'max:255'],
//            'receiver.email'              => ['nullable', 'string', 'email', 'max:255'],
//            'receiver.company_name'       => ['nullable', 'string', 'max:255'],
            'delivery_date'               => ['sometimes', 'required', 'date', 'date_format:m/d/Y', 'after_or_equal:' . date('m/d/Y')],
            'delivery_time_frame'         => ['sometimes', 'required', 'string'],
            'billing_country'             => ['sometimes', 'required', 'string'],
            'billing_state'               => ['sometimes', 'required', 'string', 'max:255'],
            'billing_street_address'      => ['sometimes', 'required', 'string', 'max:255'],
            'billing_address_opt'         => ['sometimes', 'nullable', 'string', 'max:255'],
            'billing_city'                => ['sometimes', 'required', 'string', 'max:255'],
            'billing_zip'                 => ['sometimes', 'required', 'string', 'max:255'],
            'billing_company_name'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'billing_phone_number'        => ['required', 'string', 'max:255', 'min:14'],
            'billing_email_address'       => ['sometimes', 'required', 'string', 'max:255'],
            'delivery_country'            => ['sometimes', 'required', 'string'],
            'delivery_state'              => ['sometimes', 'required', 'string', 'max:255'],
            'delivery_city'               => ['sometimes', 'required', 'string', 'max:255'],
            'delivery_street_address'     => ['sometimes', 'required', 'string', 'max:255'],
            'delivery_address_opt'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'delivery_zip'                => ['sometimes', 'required', 'string', 'max:255'],
            'delivery_company_name'       => ['sometimes', 'nullable', 'string', 'max:255'],
            'delivery_phone_number'       => ['sometimes', 'required', 'string', 'max:255', 'min:14'],
            'delivery_order_notes'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'pickup_date'                 => ['sometimes', 'required', 'date', 'date_format:m/d/Y', 'after_or_equal:' . date('m/d/Y')],
            'pickup_location'             => ['sometimes', 'required', 'string', Rule::in($pickupLocations)],
            'pickup_time_frame'           => ['sometimes', 'required'],
            'send_updates_and_promotions' => ['sometimes', 'string'],
            'payment_profile_id'          => [
                'sometimes',
                'required',
                'string',
                Rule::exists('payment_profiles', 'id')->where(function (Builder $query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'card_number'                 => ['sometimes', 'required', new CardNumber()],
            'expiration_month'            => ['sometimes', 'required', new CardExpirationMonth($this->request->get('expiration_year'))],
            'expiration_year'             => ['sometimes', 'required', new CardExpirationYear($this->request->get('expiration_month'))],
            'csc'                         => ['sometimes', 'required', new CardCvc($this->request->get('card_number'))],
            'securely_save_to_account'    => ['sometimes'],
            'coupon_id'                   => [
                'nullable',
                'numeric',
                Rule::in(
                    Coupon::whereDate('start_date', '<=', today()->format('Y-m-d'))
                        ->whereDate('expiration_date', '>', today()->format('Y-m-d'))
                        ->orWhere('start_date' , null)
                        ->orWhere('expiration_date' , null)
                        ->get()
                        ->pluck('id')
                ),
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
//            'receiver.first_name'     => 'first name',
//            'receiver.last_name'      => 'last name',
//            'receiver.email'          => 'email',
//            'receiver.company_name'   => 'company name',
            'delivery_country'        => 'country/ region',
            'delivery_state'          => 'state',
            'delivery_city'           => 'town / city',
            'delivery_street_address' => 'street address',
            'delivery_zip'            => 'ZIP',
            'delivery_company_name'   => 'company',
            'delivery_phone_number'   => 'phone number',
            'delivery_order_notes'    => 'order notes',
            'payment_profile_id'      => 'card',
        ];
    }
}
