<?php

namespace App\Http\Requests\Backend\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:255', "unique:categories,name,{$this->route('category')->id}"],
            'description' => ['nullable', 'string'],
            'thumb'       => ['nullable']
        ];
    }
}
