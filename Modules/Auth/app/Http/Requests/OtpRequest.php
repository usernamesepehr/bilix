<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
{
   public function rules(): array
    {
        if ($this->routeIs('otp-generate')){
        return [
            'email' => 'required|email|exists:users,email',
        ];
        }
        if ($this->routeIs('otp-check')){
        return [    
            'otp' => 'required|digits:5|integer',
            'email' => 'required|email|exists:users,email',
        ];
        }
    return [];
    }
    public function messages()
    {
        if ($this->routeIs('otp-generate')){
            return [
                'email.required'    => __('auth::validation.email.required'),
                'email.email'       => __('auth::validation.email.email'),
                'email.exists'      => __('auth::validation.email.exists'),
            ];
        }
        if ($this->routeIs('otp-check')){
            return [
                'otp.required' => __('auth::validation.otp.required'),
                'otp.digits' => __('auth::validation.otp.digits'),
                'otp.integer' => __('auth::validation.otp.integer'),

                'email.required'    => __('auth::validation.email.required'),
                'email.email'       => __('auth::validation.email.email'),
                'email.exists'      => __('auth::validation.email.exists'),
            ];
        }
       
       return []; 
    }
}
