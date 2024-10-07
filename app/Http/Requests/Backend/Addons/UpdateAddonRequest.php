<?php

namespace App\Http\Requests\Backend\Addons;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddonRequest extends FormRequest
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
            'name'                          => ['required', 'string', 'max:255', "unique:addons,name,{$this->route('addon')->id}"],
            'category_ids'                  => ['required', 'array', 'min:1'],
            'category_ids.*'                => ['required', 'numeric', 'exists:categories,id'],
            'required_minimum_meals_amount' => ['required', 'numeric', 'gte:1'],
            'meal_ids'                      => ['nullable', 'array'],
            'meal_ids.*'                    => ['required', 'numeric', 'exists:meals,id'],
            'meal_prices'                   => ['required', 'array', 'min:1'],
            'meal_prices.*'                 => ['required', 'numeric', 'gte:1'],
            'meal_points'                   => ['required', 'array', 'min:1'],
            'meal_points.*'                 => ['required', 'numeric', 'gte:1'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'category_ids'                  => 'categories',
            'category_ids.*'                => 'category',
            'required_minimum_meals_amount' => 'required meals amount',
            'meal_ids'                      => 'meals',
            'meal_ids.*'                    => 'meal',
            'meal_prices'                   => 'prices',
            'meal_prices.*'                 => 'price',
            'meal_points'                   => 'points',
            'meal_points.*'                 => 'points',
        ];
    }
}
