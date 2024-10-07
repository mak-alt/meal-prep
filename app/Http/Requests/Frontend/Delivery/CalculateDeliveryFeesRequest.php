<?php

namespace App\Http\Requests\Frontend\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class CalculateDeliveryFeesRequest extends FormRequest
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
            'search_address' => ['required', 'regex:/\b\d{5}\b/']
        ];
    }
}
