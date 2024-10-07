<?php

namespace App\Http\Requests\Frontend\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class RemoveCouponRequest extends FormRequest
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
            'coupon_id'    => ['required', 'numeric', 'exists:coupons,id'],
            'delivery_zip' => ['nullable', 'string', 'max:255'],
        ];
    }
}
