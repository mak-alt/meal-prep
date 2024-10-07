<?php

namespace App\Http\Requests\Frontend\Loyalty\Referrals;

use Illuminate\Foundation\Http\FormRequest;

class SendReferralInvitationRequest extends FormRequest
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
            'email'   => ['sometimes', 'required', 'string', 'email', 'max:255'],
            'subject' => ['sometimes', 'required', 'string', 'max:255'],
            'message' => ['sometimes', 'required', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return ['email' => 'to'];
    }
}
