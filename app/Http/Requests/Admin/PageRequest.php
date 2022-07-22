<?php

namespace App\Http\Requests\Admin;

use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'page.title.' . app()->getLocale() => ['required'],
            'page.title.*' => 'max:255',
            'page.alias.' . app()->getLocale() => ['required'],
            'page.alias.*' => [
                'max:255',
                UniqueTranslationRule::for('pages', 'alias->' . app()->getLocale())
                    ->ignore($this->route('page'))
            ],
            'page.content.*' => 'max:50000',
            'page.status' => 'integer',
            'page.attachments.*' => 'file',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'page.title.*' => __('Title'),
            'page.alias.*' => __('Alias'),
            'page.content.*' => __('Content'),
            'page.seo_title.*' => __('Seo title'),
            'page.seo_keywords.*' => __('Seo keywords'),
            'page.seo_description.*' => __('Seo description'),
            'page.status' => __('Show'),
            'page.attachments.*' => __('Attachments'),
        ];
    }
}
