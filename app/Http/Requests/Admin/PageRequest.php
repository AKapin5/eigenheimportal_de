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
            'page.name.' . app()->getLocale() => ['required'],
            'page.name.*' => 'max:255',
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
    public function messages(): array
    {
        return [
            'page.name.*.required' => __('Поле "Название" обязательно для заполнения.'),
            'page.alias.*.required' => __('Поле "Алиас" обязательно для заполнения.'),
            'page.attachments.*.mimes' => __('AAA'),
        ];
    }
}
