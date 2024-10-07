<?php

namespace App\Http\Requests\Backend\Addons;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddonMealRequest extends FormRequest
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
    public function rules()
    {
        $order_id = $this->order_id;
        return [
            'name'             => ['required', 'string', 'max:255', 'unique:meals,name'],
            'price'            => ['required', 'numeric', 'gte:0'],
            'points'           => ['required', 'numeric', 'gte:0'],
            'thumb'            => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'calories'         => ['required', 'numeric', 'gte:0'],
            'category_ids'     => ['required', 'array', 'min:1'],
            'category_ids.*'   => ['required', 'numeric', 'exists:addons,id'],
            'fats'             => ['required', 'numeric', 'gte:0'],
            'carbs'            => ['required', 'numeric', 'gte:0'],
            'proteins'         => ['required', 'numeric', 'gte:0'],
            'ingredient_ids'   => ['required', 'array', 'min:1'],
            'ingredient_ids.*' => ['required', 'numeric', 'exists:ingredients,id'],
            'description'      => ['nullable', 'string'],
            'order_id'         => ['required',
                Rule::unique('meals')->where(function ($query) use ($order_id){
                    return $query->where('type','addon')->where('order_id',$order_id);
                })
            ],
        ];
    }

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
