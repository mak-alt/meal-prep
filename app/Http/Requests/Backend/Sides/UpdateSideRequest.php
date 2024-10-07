<?php

namespace App\Http\Requests\Backend\Sides;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        $order_id = $this->order_id;
        return [
            'name'             => ['required', 'string', 'max:255', "unique:meals,name,{$this->route('side')->id}"],
            'price'            => ['required', 'numeric', 'gte:0'],
            'points'           => ['required', 'numeric', 'gte:0'],
            'thumb'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'calories'         => ['required', 'numeric', 'gte:0'],
            'fats'             => ['required', 'numeric', 'gte:0'],
            'carbs'            => ['required', 'numeric', 'gte:0'],
            'proteins'         => ['required', 'numeric', 'gte:0'],
            'ingredient_ids'   => ['required', 'array', 'min:1'],
            'ingredient_ids.*' => ['required', 'numeric', 'exists:ingredients,id'],
            'description'      => ['nullable', 'string'],
            'tags'             => ['nullable', 'array'],
            'status'           => ['nullable'],
            'order_id'         => ['required',
                Rule::unique('meals')->where(function ($query) use ($order_id){
                    return $query->where('type','side')->where('order_id',$order_id);
                })->ignore($this->route('side')->id)
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'ingredient_ids'   => 'ingredients',
            'ingredient_ids.*' => 'ingredient',
            'category_ids'     => 'categories',
            'category_ids.*'   => 'category',
        ];
    }
}
