<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:100',
            'phone' => 'required|digits:11|unique:users,phone',
            'city' => 'required|string|max:100',
            'profile' => 'sometimes|mimes:png,jpg,jpeg|image|max:2048',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255|regex:/^[a-zA-Z0-9]+$/'
        ];
    }
    public function messages(): array
    {
     return [
        'name.required'     => __('auth::validation.name.required'),
        'name.min'          => __('auth::validation.name.min'),
        'name.max'          => __('auth::validation.name.max'),

        'phone.required'    => __('auth::validation.phone.required'),
        'phone.digits'      => __('auth::validation.phone.digits'),
        'phone.unique'      => __('auth::validation.phone.unique'),

        'profile.mimes'     => __('auth::validation.profile.mimes'),
        'profile.image'     => __('auth::validation.profile.image'),
        'profile.max'       => __('auth::validation.profile.max'),

        'email.required'    => __('auth::validation.email.required'),
        'email.email'       => __('auth::validation.email.email'),
        'email.unique'      => __('auth::validation.email.unique'),

        'password.required' => __('auth::validation.password.required'),
        'password.min'      => __('auth::validation.password.min'),
        'password.max'      => __('auth::validation.password.max'),
        'password.regex'    => __('auth::validation.password.regex'),
    ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
