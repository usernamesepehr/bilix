<?php

namespace Modules\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAirportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'city' => 'required|string',
            'iata' => 'required|string',
            'slug' => 'sometimes|string|unique:airports,slug'
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
             

             'name.required' => 'وارد کردن نام الزامی است.',
             'name.string'   => 'نام باید به صورت متن وارد شود.',

             'city.required' => 'وارد کردن شهر الزامی است.',
             'city.string'   => 'شهر باید به صورت متن وارد شود.',

             'iata.required' => 'کد IATA الزامی است.',
             'iata.string'   => 'کد IATA باید به صورت متن وارد شود.',

             'slug.string'   => 'اسلاگ باید به صورت متن وارد شود.',
             'slug.unique'   => 'این اسلاگ قبلاً برای یک فرودگاه دیگر ثبت شده است.',
        ];
    }
}
