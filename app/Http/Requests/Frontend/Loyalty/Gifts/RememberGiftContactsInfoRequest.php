<?php

namespace App\Http\Requests\Frontend\Loyalty\Gifts;

use Illuminate\Foundation\Http\FormRequest;

class RememberGiftContactsInfoRequest extends FormRequest
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
        $sentToRules = $this->request->has('delivery_date')
            ? ['required', 'string', 'email', 'max:255']
            : ['required', 'string', 'max:255'];

        return [
            'sent_to'       => $sentToRules,
            'sender_name'   => ['required', 'email'],
            'delivery_date' => ['sometimes', 'nullable', 'date', 'date_format:m/d/Y', 'after_or_equal:' . date('m/d/Y')],
            'message'       => ['nullable', 'string'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'sent_to'     => 'send to',
            'sender_name' => 'send from',
        ];
    }
}
