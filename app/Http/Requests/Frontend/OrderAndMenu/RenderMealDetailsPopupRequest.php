<?php

namespace App\Http\Requests\Frontend\OrderAndMenu;

use Illuminate\Foundation\Http\FormRequest;

class RenderMealDetailsPopupRequest extends FormRequest
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
            'show_add_button' => ['required', 'boolean'],
            'show_sides'      => ['required', 'boolean'],
            'menu_id'         => ['sometimes', 'numeric', 'exists:menus,id']
        ];
    }
}
