<?php

namespace App\Http\Requests\Frontend\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
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
            'email'    => ['sometimes', 'required', 'string', 'max:255', 'email', 'unique:users,email'],
            'password' => ['sometimes', 'required', 'string', 'password'],
            'code'     => ['sometimes', 'required', 'exists:verification_codes,code,user_id,' . auth()->id()],
        ];
    }
}
