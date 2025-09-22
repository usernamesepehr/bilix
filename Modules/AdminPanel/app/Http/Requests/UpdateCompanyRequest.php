<?php

namespace Modules\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:companies,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'registerNumber' => 'sometimes|integer',
            'address' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:table_name,slug|max:255',
            'logo' => 'sometimes|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
    'name.string' => 'نام باید متن باشد.',
    'name.max' => 'نام نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

    'description.string' => 'توضیحات باید متن باشد.',
    'description.max' => 'توضیحات نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

    'registerNumber.integer' => 'شماره ثبت باید عدد صحیح باشد.',

    'address.string' => 'آدرس باید متن باشد.',
    'address.max' => 'آدرس نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

    'slug.string' => 'اسلاگ باید متن باشد.',
    'slug.unique' => 'این اسلاگ قبلاً استفاده شده است.',
    'slug.max' => 'اسلاگ نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

    'logo.image' => 'لوگو باید یک تصویر باشد.',
    'logo.mimes' => 'فرمت‌های مجاز برای لوگو عبارتند از: jpg, jpeg, png, gif, svg, webp.',
    'logo.max' => 'حجم لوگو نباید بیشتر از ۲ مگابایت باشد.',
        ];
    }
}
