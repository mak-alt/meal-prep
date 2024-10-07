<?php

namespace App\Http\Requests\Frontend\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class  UpdateBillingAddressRequest extends FormRequest
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
            'billing_country'                         => ['required', 'string', 'max:255', Rule::in(['United States (US)'])],
            'billing_state'                           => ['required', 'string', 'max:255'],
            'billing_city'                            => ['required', 'string', 'max:255'],
            'billing_street_address'                  => ['required', 'string', 'max:255'],
            'billing_address_opt'                     => ['nullable', 'string', 'max:255'],
            'billing_zip'                             => ['required', 'string', 'max:255'],
            'billing_company_name'                    => ['nullable', 'string', 'max:255'],
            'billing_first_name'                      => ['required_without:billing_same_name_as_account_name', 'nullable', 'string', 'max:255'],
            'billing_last_name'                       => ['required_without:billing_same_name_as_account_name', 'nullable', 'string', 'max:255'],
            'billing_use_address_as_delivery_address' => ['sometimes', 'required', 'string'],
            'billing_same_name_as_account_name'       => ['sometimes', 'required', 'string'],
            'billing_phone_number'                    => ['required', 'string', 'max:255', 'min:14'],
            'billing_email_address'                   => ['required', 'string', 'email', 'max:255'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'billing_country'                         => 'country / region',
            'billing_state'                           => 'state',
            'billing_city'                            => 'town / city',
            'billing_street_address'                  => 'street address',
            'billing_zip'                             => 'ZIP',
            'billing_company_name'                    => 'company',
            'billing_first_name'                      => 'first name',
            'billing_last_name'                       => 'last name',
            'billing_use_address_as_delivery_address' => 'use this address as my delivery address',
            'billing_same_name_as_account_name'       => 'use the same name as account name',
            'billing_phone_number'                    => 'phone number',
            'billing_email_address'                   => 'email address',
        ];
    }
}
