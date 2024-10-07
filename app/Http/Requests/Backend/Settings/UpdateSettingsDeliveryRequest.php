<?php

namespace App\Http\Requests\Backend\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsDeliveryRequest extends FormRequest
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
            'delivery' => ['required', 'array', 'min:2'],
            'delivery.within_i_285'   => ['required', 'numeric', 'between:0,999.99'],
            'delivery.outside_i_285'  => ['required', 'numeric', 'between:0,999.99'],
            'delivery.default_price'   => ['required', 'numeric'],
        ];
    }
}
