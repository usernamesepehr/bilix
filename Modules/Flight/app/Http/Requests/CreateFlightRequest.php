<?php

namespace Modules\Flight\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFlightRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'load' => 'required|integer|min:1',
            'number' => 'required|string|max:50',
            'plane' => 'required|string|max:100',
            'discount' => 'sometimes|integer|between:0,100',
            'origin_airport' =>'required|exists:airports,id',
            'destination_airport' => 'required|exists:airports,id|different:origin_airport',
            'slug' => 'sometimes|string|unique:flights,slug',
            'date' => 'required|string',
            'timeStart' => 'required|string|regex:/^\d{2}:\d{2}$/',
            'timeEnd' => 'required|string|regex:/^\d{2}:\d{2}$/',
            'options' => 'required|array',
            'options.*.quantity' => 'required|integer|min:1',
            'options.*.options_id' => 'required|array',
            'options.*.options_id.*' => 'exists:options,id', 
            'options.*.price' => 'required|string',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
                'load.required' => 'ظرفیت پرواز الزامی است.',
    'load.integer' => 'ظرفیت پرواز باید عددی باشد.',
    'load.min' => 'ظرفیت پرواز باید حداقل :min باشد.',

    'number.required' => 'شماره پرواز الزامی است.',
    'number.string' => 'شماره پرواز باید رشته‌ای باشد.',
    'number.max' => 'شماره پرواز نمی‌تواند بیش از :max کاراکتر باشد.',

    'plane.required' => 'نام هواپیما الزامی است.',
    'plane.string' => 'نام هواپیما باید رشته‌ای باشد.',
    'plane.max' => 'نام هواپیما نمی‌تواند بیش از :max کاراکتر باشد.',

    'discount.integer' => 'درصد تخفیف باید عددی باشد.',
    'discount.between' => 'درصد تخفیف باید بین :min تا :max باشد.',

    'origin_airport.required' => 'فرودگاه مبدا الزامی است.',
    'origin_airport.exists' => 'فرودگاه مبدا انتخاب‌شده معتبر نیست.',

    'destination_airport.required' => 'فرودگاه مقصد الزامی است.',
    'destination_airport.exists' => 'فرودگاه مقصد انتخاب‌شده معتبر نیست.',
    'destination_airport.different' => 'فرودگاه مقصد باید با فرودگاه مبدا متفاوت باشد.',

    'slug.sometimes' => 'مقدار slug باید در صورت وجود بررسی شود.',
    'slug.string' => 'slug باید رشته‌ای باشد.',
    'slug.unique' => 'این slug قبلاً برای یک پرواز دیگر ثبت شده است.',

    'timeStart.required' => 'زمان شروع پرواز الزامی است.',
    'timeStart.string' => 'زمان شروع پرواز باید به صورت رشته باشد.',
    'timeStart.regex' => 'زمان شروع پرواز باید در قالب HH:MM وارد شود.',

    'timeEnd.required' => 'زمان پایان پرواز الزامی است.',
    'timeEnd.string' => 'زمان پایان پرواز باید به صورت رشته باشد.',
    'timeEnd.regex' => 'زمان پایان پرواز باید در قالب HH:MM وارد شود.',

    'date.required' => 'تاریخ پرواز الزامی است.',
    'date.string' => 'تاریخ پرواز باید به صورت متن (رشته) وارد شود.',

    'options.required' => 'وارد کردن گزینه‌ها الزامی است.',
    'options.array' => 'فرمت گزینه‌ها باید آرایه باشد.',
    'options.*.quantity.required' => 'تعداد برای هر گزینه الزامی است.',
    'options.*.quantity.integer' => 'تعداد باید عدد صحیح باشد.',
    'options.*.quantity.min' => 'تعداد باید حداقل 1 باشد.',
    'options.*.options_id.required' => 'شناسه گزینه‌ها برای هر گزینه الزامی است.',
    'options.*.options_id.array' => 'شناسه گزینه‌ها باید آرایه باشد.',
    'options.*.options_id.*.exists' => 'یکی از گزینه‌های انتخاب شده معتبر نیست.',
    'options.*.price.required' => 'قیمت برای هر گزینه الزامی است.',
    'options.*.price.string' => 'قیمت باید رشته باشد.',
        ];
    }
}
