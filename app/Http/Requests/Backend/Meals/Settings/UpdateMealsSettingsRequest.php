<?php

namespace App\Http\Requests\Backend\Meals\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealsSettingsRequest extends FormRequest
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
            'portion_sizes'              => ['required', 'array', 'min:1'],
            'portion_sizes.*.size'       => ['required', 'numeric', 'min:1'],
            'portion_sizes.*.percentage' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'portion_sizes.*.size'       => 'size',
            'portion_sizes.*.percentage' => '%',
        ];
    }
}
