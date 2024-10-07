<?php

namespace App\Http\Requests\Backend\Coupons;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_code'       => ['required', 'string', 'max:255'],
            'coupon_name'       => ['required', 'string', 'max:255'],
            'discount_type'     => ['required', 'in:currency,percent'],
            'discount_value'    => ['required', 'string', 'max:255'],
            'expiration_date'   => ['nullable', 'date'],
            'start_date'        => ['nullable', 'date'],
            'description'       => ['nullable', 'string'],
            'users'             => ['nullable', 'array', 'min:1'],
            'users.*'           => ['nullable', 'numeric', 'gte:1'],
        ];
    }
}
