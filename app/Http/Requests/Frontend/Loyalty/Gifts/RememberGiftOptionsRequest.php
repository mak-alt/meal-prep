<?php

namespace App\Http\Requests\Frontend\Loyalty\Gifts;

use App\Models\Gift;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RememberGiftOptionsRequest extends FormRequest
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
        $sentToRules = ['sometimes', 'required', 'string', 'max:255'];

        if (
            $this->session->has('gift.delivery_channel') &&
            $this->session->get('gift.delivery_channel') === Gift::DELIVERY_CHANNELS['email']
        ) {
            array_push($sentToRules, 'email');
        }

        return [
//            'amount'           => ['sometimes', 'required', 'numeric', 'gte:25'],
            'amount'           => ['sometimes', 'required', 'numeric', 'gte:1'],
            'delivery_channel' => ['sometimes', 'required', Rule::in(Gift::DELIVERY_CHANNELS)],
            'sent_to'          => $sentToRules,
            'sender_name'      => ['sometimes', 'required', 'string', 'max:255'],
            'delivery_date'    => ['sometimes', 'required', 'date_format:m/d/Y', 'after_or_equal:' . date('m/d/Y')],
            'message'          => ['sometimes', 'required', 'string'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'delivery_channel' => 'delivery type',
            'sent_to'          => 'to',
            'sender_name'      => 'from',
        ];
    }
}
