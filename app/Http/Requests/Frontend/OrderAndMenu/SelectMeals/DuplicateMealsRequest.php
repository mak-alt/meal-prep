<?php

namespace App\Http\Requests\Frontend\OrderAndMenu\SelectMeals;

use App\Models\Order;
use App\Services\SessionStorageHandlers\MealsSessionStorageService;
use Illuminate\Foundation\Http\FormRequest;

class DuplicateMealsRequest extends FormRequest
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
            'amount'          => [
                'required',
                'numeric',
                'between:1,' . (session()->get(Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']) - count(MealsSessionStorageService::getIds()))
            ],
            'entry_meal_id'   => ['required_without:side_meal_ids', 'numeric', 'exists:meals,id'],
            'side_meal_ids'   => ['required_without:entry_meal_id', 'array'],
            'side_meal_ids.*' => ['required_without:entry_meal_id', 'numeric', 'exists:meals,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'entry_meal_id'  => 'entry meal',
            'side_meal_ids'  => 'side meals',
            'side_meal_id.*' => 'side meal',
        ];
    }
}
