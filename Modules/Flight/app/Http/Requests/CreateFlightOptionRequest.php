<?php

namespace Modules\Flight\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createFlightOptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'flight_id' => 'required|integer|exists:flights,id',
            'quantity' => 'required|integer|min:1',
            'options_id' => 'required|array',
            'options_id.*' => 'exists:options,id', 
            'price' => 'required|string',
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
    'quantity.required' => 'تعداد برای هر گزینه الزامی است.',
    'quantity.integer' => 'تعداد باید عدد صحیح باشد.',
    'quantity.min' => 'تعداد باید حداقل 1 باشد.',
    'options_id.required' => 'شناسه گزینه‌ها برای هر گزینه الزامی است.',
    'options_id.array' => 'شناسه گزینه‌ها باید آرایه باشد.',
    'options_id.*.exists' => 'یکی از گزینه‌های انتخاب شده معتبر نیست.',
    'price.required' => 'قیمت برای هر گزینه الزامی است.',
    'price.string' => 'قیمت باید رشته باشد.',
        ];
    }
}
