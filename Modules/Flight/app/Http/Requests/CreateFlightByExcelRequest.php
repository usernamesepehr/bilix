<?php

namespace Modules\Flight\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFlightByExcelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
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
            'file.required' => 'لطفاً یک فایل انتخاب کنید.',
            'file.mimes'    => 'فرمت فایل باید اکسل یا  CSV باشد.',
            'file.max'      => 'حجم فایل نباید بیشتر از ۲ مگابایت باشد.',
        ];
    }
}
