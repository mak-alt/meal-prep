<?php

namespace App\Http\Requests\Frontend\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CalculateTotalPriceRequest extends FormRequest
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
            'delivery_zip' => ['nullable', 'string', 'max:255'],
            'coupon_id'    => ['nullable', 'numeric', 'exists:coupons,id'],
        ];
    }
}
