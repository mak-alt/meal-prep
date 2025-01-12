<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class WeeklyMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'data.meals' => 'nullable|array',
            'data.sides' => 'nullable|array',
            'data.other' => 'nullable|array',
            'status' => 'nullable',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
        ];
    }
}
