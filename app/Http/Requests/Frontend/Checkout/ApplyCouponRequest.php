<?php

namespace App\Http\Requests\Frontend\Checkout;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplyCouponRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'coupon_code' => strtolower($this->coupon_code),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $coupons = Coupon::whereDate('start_date', '<=', today()->format('Y-m-d'))
            ->whereDate('expiration_date', '>', today()->format('Y-m-d'))
            ->orWhere('start_date' , null)
            ->orWhere('expiration_date' , null)
            ->get()
            ->pluck('coupon_code')
            ->map(function ($item){
                return strtolower($item);
            });
        return [
            'coupon_code' => [
                'required',
                'string',
                Rule::in($coupons),
            ],
            'total_price' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
