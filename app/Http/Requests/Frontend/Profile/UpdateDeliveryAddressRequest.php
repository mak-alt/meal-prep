<?php

namespace App\Http\Requests\Frontend\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeliveryAddressRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'delivery_country'                        => ['required', 'string', 'max:255', Rule::in(['United States (US)'])],
            'delivery_state'                          => ['required', 'string', 'max:255'],
            'delivery_city'                           => ['required', 'string', 'max:255'],
            'delivery_street_address'                 => ['required', 'string', 'max:255'],
            'delivery_address_opt'                    => ['nullable', 'string', 'max:255'],
            'delivery_zip'                            => ['required', 'string', 'max:255'],
            'delivery_company_name'                   => ['nullable', 'string', 'max:255'],
            'delivery_phone_number'                   => ['required', 'string', 'max:255', 'min:14'],
            'delivery_first_name'                     => ['required_without:delivery_same_name_as_account_name', 'nullable', 'string', 'max:255'],
            'delivery_last_name'                      => ['required_without:delivery_same_name_as_account_name', 'nullable', 'string', 'max:255'],
            'delivery_use_address_as_billing_address' => ['sometimes', 'required', 'string'],
            'delivery_same_name_as_account_name'      => ['sometimes', 'required', 'string'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'delivery_country'                        => 'country / region',
            'delivery_state'                          => 'state',
            'delivery_city'                           => 'town / city',
            'delivery_street_address'                 => 'street address',
            'delivery_zip'                            => 'ZIP',
            'delivery_company_name'                   => 'company',
            'delivery_first_name'                     => 'first name',
            'delivery_last_name'                      => 'last name',
            'delivery_use_address_as_billing_address' => 'use this address as my billing address',
            'delivery_same_name_as_account_name'      => 'use the same name as account name',
        ];
    }
}
