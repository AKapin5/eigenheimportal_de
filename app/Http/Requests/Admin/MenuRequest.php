<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'menu.title.' . app()->getLocale() => ['required'],
            'menu.title.*' => 'max:255',
            'menu.url.*' => 'max:255',
            'menu.parent_id' => 'integer',
            'menu.status' => 'integer',
            'menu.sort' => 'integer',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'menu.title' => __('Title'),
            'menu.url' => __('URL'),
            'menu.parent_id' => __('Parent'),
            'menu.status' => __('Show'),
            'menu.sort' => __('Sort'),
        ];
    }
}
