<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCertificateRequest extends FormRequest
{
   
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
            'title.required' => __('company::validation.title.required'),
            'title.string' => __('company::validation.title.string'),
            'title.max' => __('company::validation.title.max'),

            'issuer.required' => __('company::validation.issuer.required'),
            'issuer.string' => __('company::validation.issuer.string'),
            'issuer.max' => __('company::validation.issuer.string'),

            'photo.required' => __('company::validation.photo.required'),
            'photo.image' => __('company::validation.photo.image'),
            'photo.mimes' => __('company::validation.photo.mimes'),
            'photo.max' => __('company::validation.photo.max'),

        ];
    }
}
