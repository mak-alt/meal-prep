<?php

namespace App\Http\Requests\Frontend\OrderAndMenu\SelectMeals;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class ValidateMealCreationStep extends FormRequest
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
            'wanted_meal_number' => ['required', 'numeric', 'lte:' . session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection'])],
        ];
    }
}
