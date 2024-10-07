<?php

namespace App\Http\Requests\Backend\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $customerRole = User::ROLES['user'];

        $profileDataRequirementRule = $this->request->get('role') === $customerRole && $this->request->has('update_profile')
            ? "required_if:role,$customerRole"
            : 'nullable';

        return [
            'first_name'              => ['required', 'string', 'max:255'],
            'last_name'               => ['nullable', 'string', 'max:255'],
            'name'                    => ['required', 'string', 'max:255', 'unique:users,name,'.$this->route('user')->id],
            'email'                   => ['required', 'string', 'email', "unique:users,email,{$this->route('user')->id}"],
            'role'                    => ['required', 'string', Rule::in(User::ROLES)],
            'password'                => ['nullable', 'string', (new Password)->requireUppercase()->requireSpecialCharacter()],
            'display_name'            => ['nullable', 'string', 'max:255'],
            'delivery_country'        => [$profileDataRequirementRule, 'string', 'max:255', Rule::in(['United States (US)'])],
            'delivery_state'          => [$profileDataRequirementRule, 'string', 'max:255'],
            'delivery_city'           => [$profileDataRequirementRule, 'string', 'max:255'],
            'delivery_street_address' => [$profileDataRequirementRule, 'string', 'max:255'],
            'delivery_zip'            => [$profileDataRequirementRule, 'string', 'max:255'],
            'delivery_company_name'   => ['nullable', 'string', 'max:255'],
            'delivery_first_name'     => ['nullable', 'string', 'max:255'],
            'delivery_last_name'      => ['nullable', 'string', 'max:255'],
            'billing_country'         => [$profileDataRequirementRule, 'string', 'max:255', Rule::in(['United States (US)'])],
            'billing_state'           => [$profileDataRequirementRule, 'string', 'max:255'],
            'billing_city'            => [$profileDataRequirementRule, 'string', 'max:255'],
            'billing_street_address'  => [$profileDataRequirementRule, 'string', 'max:255'],
            'billing_zip'             => [$profileDataRequirementRule, 'string', 'max:255'],
            'billing_company_name'    => ['nullable', 'string', 'max:255'],
            'billing_first_name'      => ['nullable', 'string', 'max:255'],
            'billing_last_name'       => ['nullable', 'string', 'max:255'],
            'billing_phone_number'    => [$profileDataRequirementRule, 'string', 'max:255'],
            'billing_email_address'   => [$profileDataRequirementRule, 'string', 'email', 'max:255'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'role'                                    => 'account type',
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
