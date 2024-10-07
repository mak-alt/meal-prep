<?php

namespace App\Http\Requests\Frontend\OrderAndMenu\Addons;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToggleMealSelectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'meal_id'   => ['required', 'numeric', 'exists:meals,id'],
            'operation' => ['required', 'string', Rule::in(['select', 'unselect'])],
        ];
    }
}
