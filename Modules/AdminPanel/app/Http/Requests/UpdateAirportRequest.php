<?php

namespace Modules\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAirportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:airports,id',
            'name' => 'sometimes|string',
            'city' => 'sometimes|string',
            'iata' => 'sometimes|string',
            'slug' => 'sometimes|string|unique:airports,slug'
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
            'id.required' => 'شناسه فرودگاه الزامی است.',
            'id.integer'  => 'شناسه فرودگاه باید عدد صحیح باشد.',
            'id.exists'   => 'فرودگاهی با این شناسه در سیستم وجود ندارد.',
     
            'name.string' => 'نام باید به صورت متن وارد شود.',

            'city.string' => 'شهر باید به صورت متن وارد شود.',

            'iata.string' => 'کد IATA باید به صورت متن وارد شود.',

            'slug.string' => 'اسلاگ باید به صورت متن وارد شود.',
            'slug.unique' => 'این اسلاگ قبلاً برای یک فرودگاه دیگر ثبت شده است.',
        ];
    }

}
