<?php

namespace Modules\Flight\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlightRequest extends FormRequest
{
   
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'load' => 'sometimes|integer|min:1',
            'number' => 'sometimes|string|max:50',
            'plane' => 'sometimes|string|max:100',
            'discount' => 'sometimes|integer|between:0,100',
            'origin_airport' =>'sometimes|exists:airports,id',
            'destination_airport' => 'sometimes|exists:airports,id|different:origin_airport',
            'slug' => 'sometimes|string|unique:flights,slug',
            'date' => 'sometimes|string',
            'timeStart' => 'sometimes|string|regex:/^\d{2}:\d{2}$/',
            'timeEnd' => 'sometimes|string|regex:/^\d{2}:\d{2}$/',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
    'load.integer' => 'ظرفیت پرواز باید عددی باشد.',
    'load.min' => 'ظرفیت پرواز باید حداقل :min باشد.',

    'number.string' => 'شماره پرواز باید رشته‌ای باشد.',
    'number.max' => 'شماره پرواز نمی‌تواند بیش از :max کاراکتر باشد.',

    'plane.string' => 'نام هواپیما باید رشته‌ای باشد.',
    'plane.max' => 'نام هواپیما نمی‌تواند بیش از :max کاراکتر باشد.',

    'discount.integer' => 'درصد تخفیف باید عددی باشد.',
    'discount.between' => 'درصد تخفیف باید بین :min تا :max باشد.',

    'origin_airport.exists' => 'فرودگاه مبدا انتخاب‌شده معتبر نیست.',

    'destination_airport.exists' => 'فرودگاه مقصد انتخاب‌شده معتبر نیست.',
    'destination_airport.different' => 'فرودگاه مقصد باید با فرودگاه مبدا متفاوت باشد.',

    'slug.sometimes' => 'مقدار slug باید در صورت وجود بررسی شود.',
    'slug.string' => 'slug باید رشته‌ای باشد.',
    'slug.unique' => 'این slug قبلاً برای یک پرواز دیگر ثبت شده است.',

    'timeStart.string' => 'زمان شروع پرواز باید به صورت رشته باشد.',
    'timeStart.regex' => 'زمان شروع پرواز باید در قالب HH:MM وارد شود.',

    'timeEnd.string' => 'زمان پایان پرواز باید به صورت رشته باشد.',
    'timeEnd.regex' => 'زمان پایان پرواز باید در قالب HH:MM وارد شود.',

    'date.string' => 'تاریخ پرواز باید به صورت متن (رشته) وارد شود.',
        ];
    }
}
