<?php

namespace Modules\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:users,id',
            'company_id' => 'required_if:role,مالک شرکت,ادمین شرکت|integer|exists:companies,id',
            'name' => 'sometimes|min:3|max:100',
            'phone' => 'sometimes|digits:11|unique:users,phone',
            'city' => 'sometimes|string|max:100',
            'profile' => 'sometimes|mimes:png,jpg,jpeg|image|max:2048',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|min:8|max:255|regex:/^[a-zA-Z0-9]+$/',
            'role' => 'sometimes|string' 
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
    return [
        'id.required'   => 'شناسه کاربر الزامی است.',
        'id.integer'    => 'شناسه کاربر باید عددی باشد.',
        'id.exists'     => 'کاربر انتخاب‌شده معتبر نیست.',

        'company_id.required_if' => 'شناسه شرکت زمانی الزامی است که نقش شما «مالک شرکت» یا «ادمین شرکت» باشد.',
        'company_id.integer'     => 'شناسه شرکت باید عددی باشد.',
        'company_id.exists'      => 'شرکت انتخاب‌شده معتبر نیست.',

        'name.sometimes' => 'فیلد نام در صورت ارسال باید معتبر باشد.',
        'name.min'       => 'نام باید حداقل ۳ کاراکتر باشد.',
        'name.max'       => 'نام نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.',

        'phone.sometimes' => 'فیلد شماره موبایل در صورت ارسال ب'
        ];
    }
}
