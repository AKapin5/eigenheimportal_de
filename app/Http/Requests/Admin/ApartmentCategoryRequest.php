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
            'apartmentCategory.description.*' => 'max:50000',
            'apartmentCategory.seo_title.*' => 'max:255',
            'apartmentCategory.seo_keywords.*' => 'max:50000',
            'apartmentCategory.seo_description.*' => 'max:50000',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'apartmentCategory.title.*.required' => __('Field "Title" is required.'),
            'apartmentCategory.alias.*.required' => __('Field "Alias" is required.'),
        ];
    }
}
