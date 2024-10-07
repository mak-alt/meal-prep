<?php

namespace App\Http\Requests\Frontend\Loyalty\Referrals;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCodeRequest extends FormRequest
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
            'code' => ['required', 'string', 'regex:/^\S*$/u', 'min:8', 'max:255', 'unique:users,referral_code'],
        ];
    }
}
