<?php

namespace App\Http\Requests\Backend\Addons;

use Illuminate\Foundation\Http\FormRequest;

class RenderSelectedMealsTableItemsRequest extends FormRequest
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
            'meal_ids'   => ['nullable', 'array'],
            'meal_ids.*' => ['nullable', 'numeric', 'exists:meals,id'],
            'addon_id'   => ['sometimes', 'numeric', 'exists:addons,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'meal_ids'   => 'meals',
            'meal_ids.*' => 'meal',
        ];
    }
}
