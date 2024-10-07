<?php

namespace App\Http\Requests\Backend\Menus;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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

    public function prepareForValidation(): void
    {
        $emptyMealIds = [];

        foreach ($this->get('meal_ids', []) as $mealId) {
            if (!array_key_exists($mealId, $this->get('meal_side_ids', []))) {
                $emptyMealIds[] = $mealId;
            }
        }

        $mealSideIdsData = $this->get('meal_side_ids', []);
        foreach ($emptyMealIds as $mealId) {
            $mealSideIdsData[$mealId] = [];
        }

        $this->merge(['meal_side_ids' => $mealSideIdsData]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255', 'unique:menus,name'],
            'category_id'       => ['required', 'numeric', 'exists:categories,id'],
            'price'             => ['required', 'numeric', 'gte:0'],
            'points'            => ['required', 'numeric', 'gte:0'],
            'calories'          => ['required', 'numeric', 'gt:0'],
            'fats'              => ['required', 'numeric', 'gt:0'],
            'carbs'             => ['required', 'numeric', 'gt:0'],
            'proteins'          => ['required', 'numeric', 'gt:0'],
            'meal_ids'          => ['required', 'array', 'min:1'],
            'meal_ids.*'        => ['required', 'numeric', 'exists:meals,id'],
            'meal_side_ids'     => ['required', 'array', 'min:1'],
            'meal_side_ids.*'   => ['nullable', 'array'],
            'meal_side_ids.*.*.*' => ['required', 'numeric', 'exists:meals,id'],
            'description'       => ['nullable', 'string'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'category_id'     => 'category',
            'meal_ids'        => 'meals',
            'meal_ids.*'      => 'meal',
            'meal_side_ids'   => 'meal sides',
            'meal_side_ids.*' => 'meal sides',
        ];
    }
}
