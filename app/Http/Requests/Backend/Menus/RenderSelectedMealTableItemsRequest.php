<?php

namespace App\Http\Requests\Backend\Menus;

use Illuminate\Foundation\Http\FormRequest;

class RenderSelectedMealTableItemsRequest extends FormRequest
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
            'meal_id' => ['sometimes', 'numeric', 'exists:meals,id'],
            'times' => ['sometimes', 'numeric'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'meal_id' => 'meal',
        ];
    }
}
