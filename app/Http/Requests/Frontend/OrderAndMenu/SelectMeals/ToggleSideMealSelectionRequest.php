<?php

namespace App\Http\Requests\Frontend\OrderAndMenu\SelectMeals;

use App\Services\SessionStorageHandlers\MealsSessionStorageService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToggleSideMealSelectionRequest extends FormRequest
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

    public function prepareForValidation(): void
    {
        $this->merge([
            'entry_meal_id' => MealsSessionStorageService::getIds($this->request->get('meal_number'))[0] ?? null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'meal_number'   => ['required', 'numeric'],
            'entry_meal_id' => ['nullable', 'numeric', 'exists:meals,id'],
            'operation'     => ['required', 'string', Rule::in(['select', 'unselect'])],
        ];
    }
}
