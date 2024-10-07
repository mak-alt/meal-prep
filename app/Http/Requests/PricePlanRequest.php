<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PricePlanRequest extends FormRequest
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
            'plan.*.price' => 'required|numeric',
            'plan.*.count' => 'required|int',
        ];
    }

    public function messages()
    {
        return [
            'plan.*.price.required'   => 'You haven`t provided a price.',
            'plan.*.price.numeric'    => 'The price field has to be a numeric value.',
            'plan.*.count.required'   => 'You haven`t provided a amount of meals.',
            'plan.*.count.int'        => 'The amount field must be integer.',
        ];
    }
}
