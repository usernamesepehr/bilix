<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|max:255|regex:/^[a-zA-Z0-9]+$/'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
        'email.required'    => __('auth::validation.email.required'),
        'email.email'       => __('auth::validation.email.email'),
        'email.exists'      => __('auth::validation.email.exists'),

        'password.required' => __('auth::validation.password.required'),
        'password.min'      => __('auth::validation.password.min'),
        'password.max'      => __('auth::validation.password.max'),
        'password.regex'    => __('auth::validation.password.regex'),
    ];
    }
}
