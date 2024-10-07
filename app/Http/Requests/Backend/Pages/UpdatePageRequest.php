<?php

namespace App\Http\Requests\Backend\Pages;

use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (!empty($this->slug)) {
            $this->merge([
                'slug' => $this->slug !== '/' ? Str::slug($this->slug) : $this->slug,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $pageSpecificRules = [];
        $rules             = [
            'name'            => ['sometimes', 'required', 'string', 'max:255', "unique:pages,name,{$this->page->id}"],
            'slug'            => ['sometimes', 'required', 'string', 'max:255', "unique:pages,slug,{$this->page->id}"],
            'status'          => ['sometimes', 'required', Rule::in(Page::STATUSES)],
            'title'           => ['required', 'string', 'max:255'],
            'content'         => ['sometimes', 'nullable', 'string'],
            'seo_title'       => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
        ];

        if ($this->page->name === 'partnersAndReferences') {
            $pageSpecificRules = [
                'data.first_local_partners'               => ['required', 'array', 'min:1'],
                'data.first_local_partners.title'         => ['required', 'string', 'max:255'],
                'data.first_local_partners.items.*.text'  => ['required', 'string', 'max:255'],
                'data.first_local_partners.items.*.image' => ['sometimes', 'nullable', 'file', 'mimes:jpg,jpeg,png,gif'],

                'data.second_local_partners'               => ['required', 'array', 'min:1'],
                'data.second_local_partners.title'         => ['required', 'string', 'max:255'],
                'data.second_local_partners.items.*.text'  => ['required', 'string', 'max:255'],
                'data.second_local_partners.items.*.image' => ['sometimes', 'nullable', 'file', 'mimes:jpg,jpeg,png,gif'],

                'data.recipe_adaptation_references'               => ['required', 'array', 'min:1'],
                'data.recipe_adaptation_references.title'         => ['required', 'string', 'max:255'],
                'data.recipe_adaptation_references.items.*.link'  => ['required', 'string', 'max:255'],
                'data.recipe_adaptation_references.items.*.image' => ['sometimes', 'nullable', 'file', 'mimes:jpg,jpeg,png,gif']
            ];
        }

        if ($this->page->name === 'deliveryAndPickup') {
            $pageSpecificRules = [
                'data.delivery_and_pickup_timing'                     => ['required', 'array', 'min:1'],
                'data.delivery_and_pickup_timing.title'               => ['required', 'string', 'max:255'],
                'data.delivery_and_pickup_timing.items.*.title'       => ['required', 'string', 'max:255'],
                'data.delivery_and_pickup_timing.items.*.description' => ['required', 'string'],

                'data.delivery_fees.title'       => ['required', 'string', 'max:255'],
                'data.delivery_fees.description' => ['required', 'string'],
                'data.delivery_fees.button'      => ['required', 'string', 'max:255'],
                'data.delivery_fees.placeholder' => ['required', 'string', 'max:255'],
                'data.delivery_fees.coefficient' => ['required', 'between:0,9999.99'],

                'data.contact_info.title'   => ['required', 'string', 'max:255'],
                'data.contact_info.address' => ['required', 'string'],
                'data.contact_info.phone'   => ['required', 'string'],
                'data.contact_info.email'   => ['required', 'email'],


                'data.pickup_locations'                 => ['required', 'array', 'min:1'],
                'data.pickup_locations.title'           => ['required', 'string', 'max:255'],
                'data.pickup_locations.description'     => ['required', 'string'],
                'data.pickup_locations.items.*.name'    => ['required', 'string', 'max:255'],
                'data.pickup_locations.items.*.address' => ['required', 'string'],

            ];
        }

        if ($this->page->name === 'galleryAndReviews') {
            $pageSpecificRules = [
                'data.gallery.items'   => ['nullable', 'array'],
                'data.gallery.items.*' => ['required', 'string'],
                'data.reviews.items'   => ['nullable', 'array'],
                'data.reviews.items.*' => ['required', 'string'],
            ];
        }

        return array_merge($rules, $pageSpecificRules);
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'data.gallery.items'   => 'files',
            'data.gallery.items.*' => 'file',
            'data.reviews.items'   => 'files',
            'data.reviews.items.*' => 'file',
        ];
    }
}
