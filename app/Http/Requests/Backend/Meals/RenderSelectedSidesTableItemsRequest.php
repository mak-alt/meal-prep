<?php

namespace App\Http\Requests\Backend\Meals;

use Illuminate\Foundation\Http\FormRequest;

class RenderSelectedSidesTableItemsRequest extends FormRequest
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
            'side_ids'   => ['nullable', 'array'],
            'side_ids.*' => ['nullable', 'numeric', 'exists:meals,id'],
            'meal_id'    => ['sometimes', 'numeric', 'exists:meals,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'side_ids'   => 'side meals',
            'side_ids.*' => 'side meal',
        ];
    }
}
