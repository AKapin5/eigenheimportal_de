<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentCategoryRequest extends FormRequest
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
            'apartmentCategory.name.' . app()->getLocale() => ['required'],
            'apartmentCategory.name.*' => 'max:255',
            'apartmentCategory.alias.' . app()->getLocale() => ['required'],
            'apartmentCategory.alias.*' => 'max:255',
            'apartmentCategory.parent_id' => 'integer|nullable',
            'apartmentCategory.status' => 'integer',
            'apartmentCategory.sort' => 'integer|nullable',
            'apartmentCategory.description.*' => 'max:50000',
            'apartmentCategory.seo_title.*' => 'max:255',
            'apartmentCategory.seo_keywords.*' => 'max:50000',
            'apartmentCategory.seo_description.*' => 'max:50000',
            'apartmentCategory.photo' => 'image',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'apartmentCategory.name.*' => __('Name'),
            'apartmentCategory.alias.*' => __('Alias'),
            'apartmentCategory.description.*' => __('Description'),
            'apartmentCategory.seo_title.*' => __('Seo title'),
            'apartmentCategory.seo_keywords.*' => __('Seo keywords'),
            'apartmentCategory.seo_description.*' => __('Seo description'),
            'apartmentCategory.photo' => __('Photo'),
            'apartmentCategory.parent_id' => __('Parent'),
            'apartmentCategory.status' => __('Show'),
            'apartmentCategory.sort' => __('Sort'),
        ];
    }
}
