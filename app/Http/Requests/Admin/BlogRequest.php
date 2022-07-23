<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'blog.name.' . app()->getLocale() => ['required'],
            'blog.name.*' => 'max:255',
            'blog.alias.' . app()->getLocale() => ['required'],
            'blog.alias.*' => 'max:255',
            'blog.category_id' => 'integer|nullable|required',
            'blog.status' => 'integer',
            'blog.short_text.*' => 'max:400',
            'blog.description.*' => 'max:50000',
            'blog.seo_title.*' => 'max:255',
            'blog.seo_keywords.*' => 'max:50000',
            'blog.seo_description.*' => 'max:50000',
            'blog.photo' => 'image',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'blog.name.*' => __('Name'),
            'blog.alias.*' => __('Alias'),
            'blog.short_text.*' => __('Short text'),
            'blog.description.*' => __('Description'),
            'blog.seo_title.*' => __('Seo title'),
            'blog.seo_keywords.*' => __('Seo keywords'),
            'blog.seo_description.*' => __('Seo description'),
            'blog.category_id' => __('Category'),
            'blog.status' => __('Show'),
            'blog.photo' => __('Photo'),
        ];
    }
}
