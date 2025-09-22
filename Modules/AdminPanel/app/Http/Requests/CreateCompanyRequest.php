<?php

namespace Modules\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'registerNumber' => 'required|integer',
            'address' => 'required|string|max:255',
            'slug' => 'sometimes|string|unique:table_name,slug|max:255',
            'logo' => 'sometimes|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
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
            'name.required' => 'وارد کردن نام الزامی است.',
    'name.string' => 'نام باید متن باشد.',
    'name.max' => 'نام نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

    'description.required' => 'وارد کردن توضیحات الزامی است.',
    'description.string' => 'توضیحات باید متن باشد.',
    'description.max' => 'توضیحات نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

    'registerNumber.required' => 'شماره ثبت الزامی است.',
    'registerNumber.integer' => 'شماره ثبت باید عدد صحیح باشد.',

    'address.required' => 'وارد کردن آدرس الزامی است.',
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
