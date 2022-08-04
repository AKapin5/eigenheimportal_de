<?php

namespace App\Http\Requests\Admin;

use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryRequest extends FormRequest
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
            'blogCategory.name.' . app()->getLocale() => ['required'],
            'blogCategory.name.*' => 'max:255',
            'blogCategory.alias.' . app()->getLocale() => ['required'],
            'blogCategory.alias.*' => [
                'max:255',
                UniqueTranslationRule::for('blog_categories', 'alias')->ignore($this->route('blogCategory'))
            ],
            'blogCategory.status' => 'integer',
            'blogCategory.sort' => 'integer|nullable',
            'blogCategory.seo_title.*' => 'max:255',
            'blogCategory.seo_keywords.*' => 'max:50000',
            'blogCategory.seo_description.*' => 'max:50000',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'blogCategory.name.*' => __('Name'),
            'blogCategory.alias.*' => __('Alias'),
            'blogCategory.seo_title.*' => __('Seo title'),
            'blogCategory.seo_keywords.*' => __('Seo keywords'),
            'blogCategory.seo_description.*' => __('Seo description'),
            'blogCategory.status' => __('Show'),
            'blogCategory.sort' => __('Sort'),
        ];
    }
}
