<?php

namespace App\Http\Requests\Backend\Meals;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMultipleMealsRequest extends FormRequest
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
            'meal_ids'   => ['required', 'array', 'min:1'],
            'meal_ids.*' => ['required', 'numeric', 'exists:meals,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'meal_ids'   => 'selection',
            'meal_ids.*' => 'checkbox',
        ];
    }
}
