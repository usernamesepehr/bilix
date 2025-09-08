<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'role' => 'required|string|min:3|max:50'
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
            'role.required' => __('auth::validation.role.required'),
            'role.string' => __('auth::validation.role.string'),
            'role.min' => __('auth::validation.role.min'),
            'role.max' => __('auth::validation.role.max'),
        ];
    }
}
