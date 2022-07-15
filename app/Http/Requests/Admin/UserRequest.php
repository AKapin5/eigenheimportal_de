<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'user.email' => [
                'required',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($this->route('user'), 'id')
            ],
            'user.role' => 'required:integer',
            'user.status' => 'integer',
            //'user.photo' => 'image',
        ];
    }
    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'user.role' => __('Role'),
            'user.email' => __('E-mail'),
            'user.photo' => __('Photo'),
            'user.status' => __('Status'),
        ];
    }
}
