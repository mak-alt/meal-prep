<?php

namespace App\Http\Requests\Backend\Loyalty\Gifts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGiftRequest extends FormRequest
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
        return [
            'sender_name'   => ['required', 'string', 'max:255'],
            'sent_to'       => ['required', 'string', 'max:255', 'email'],
            'delivery_date' => ['required', 'date_format:Y-m-d'],
            'message'       => ['required', 'string'],
            'amount'        => ['required', 'numeric', 'gt:0'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'sent_to' => 'receiver email',
        ];
    }
}
