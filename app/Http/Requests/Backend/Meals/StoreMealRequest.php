<?php

namespace App\Http\Requests\Backend\Meals;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMealRequest extends FormRequest
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
        $order_id = $this->order_id;
        return [
            'name'             => ['required', 'string', 'max:255', 'unique:meals,name'],
            'side_count'        => ['required','numeric'],
            'price'            => ['required', 'numeric', 'gte:0'],
            'points'           => ['required', 'numeric', 'gte:0'],
            'thumb'            => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
//            'category_ids'     => ['required', 'array', 'min:1'],
//            'category_ids.*'   => ['required', 'numeric', 'exists:categories,id'],
            'calories'         => ['required', 'numeric', 'gte:0'],
            'fats'             => ['required', 'numeric', 'gte:0'],
            'carbs'            => ['required', 'numeric', 'gte:0'],
            'proteins'         => ['required', 'numeric', 'gte:0'],
            'ingredient_ids'   => ['required', 'array', 'min:1'],
            'ingredient_ids.*' => ['required', 'numeric', 'exists:ingredients,id'],
            'side_ids'         => ['nullable', 'array'],
            'side_ids.*'       => ['nullable', 'numeric', 'exists:meals,id'],
            'side_prices'      => ['nullable', 'array', 'min:1'],
            'side_prices.*'    => ['required', 'numeric', 'gte:0'],
            'side_points'      => ['nullable', 'array', 'min:1'],
            'side_points.*'    => ['required', 'numeric', 'gte:0'],
            'description'      => ['nullable', 'string'],
            'tags'             => ['nullable', 'array'],
            'status'           => ['nullable'],
            'order_id'         => ['required',
                Rule::unique('meals')->where(function ($query) use ($order_id){
                    return $query->where('type','entry')->where('order_id',$order_id);
                })
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
//            'category_ids'     => 'categories',
//            'category_ids.*'   => 'category',
            'ingredient_ids'   => 'ingredients',
            'ingredient_ids.*' => 'ingredient',
            'side_ids'         => 'side meals',
            'side_ids.*'       => 'side meal',
            'side_prices'      => 'prices',
            'side_prices.*'    => 'prices',
            'side_points'      => 'points',
            'side_points.*'    => 'points',
        ];
    }
}
