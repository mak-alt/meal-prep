<?php

namespace App\Http\Requests\Frontend\Newsletter;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:newsletter_subscribers,email'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return ['email.unique' => 'You are already subscriber to our updates.'];
    }
}
