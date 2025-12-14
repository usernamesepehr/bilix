<?php

namespace Modules\Flight\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Flight_meta;

class FlightsExcelHandlerService extends ExcelHandlerService {

     protected static function rules(): array
     {
     return [
        'load' => 'required|integer|min:1',
        'number' => 'required|string|max:50|unique:flights,number',
        'plane' => 'required|string|max:100',
        'discount' => 'nullable|integer|between:0,100',
        'origin_airport' =>'required|exists:airports,id',
        'destination_airport' => 'required|exists:airports,id|different:origin_airport',
        'slug' => 'nullable|string|unique:flights,slug',
        'date' => 'required|string',
        'timeStart' => 'required|string|regex:/^\d{2}:\d{2}$/',
        'timeEnd' => 'required|string|regex:/^\d{2}:\d{2}$/',
     ];
    }
     protected static function messages(): array
     {
     return [
     'load.required' => 'ظرفیت پرواز الزامی است.',
    'load.integer' => 'ظرفیت پرواز باید عددی باشد.',
    'load.min' => 'ظرفیت پرواز باید حداقل :min باشد.',

    'number.required' => 'شماره پرواز الزامی است.',
    'number.string' => 'شماره پرواز باید رشته‌ای باشد.',
    'number.max' => 'شماره پرواز نمی‌تواند بیش از :max کاراکتر باشد.',
    'number.unique'    => 'این شماره پرواز قبلاً ثبت شده است.',

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
     ];
    }
     public static function Validator($data)
     {
      //   dd([$data["\x00*\x00items"], self::rules(), self::messages()]);
        $validator = Validator::make($data["\x00*\x00items"], self::rules(), self::messages());
      //   dd($validator->errors());

        if ($validator->fails()) {
           return ['errors' => $validator->errors()];
        } 

      //   return new self($validator->validated());
     }

     public static function Create(ExcelHandlerService $excelHandlerService, ...$args): void
     {
          $flight = Flight::create([
        'load' => $excelHandlerService->validated['load'],
        'number' => $excelHandlerService->validated['number'],
        'plane' => $excelHandlerService->validated['plane'],
        'discount' => $excelHandlerService->validated['discount'],
        'origin_airport' => $excelHandlerService->validated['origin_airport'],
        'destination_airport' => $excelHandlerService->validated['destination_airport'],
        'company_id' => $args['company_id'],
        'slug' => $excelHandlerService->validated['slug'], 
        'date' => $excelHandlerService->validated['date'],
        'timeStart' => $excelHandlerService->validated['timeStart'],
        'timeEnd' => $excelHandlerService->validated['timeEnd'],
        ]);
    
    if(empty($flight->slug)){
        $flight->slug = Str::slug($flight->number . '-' . $flight->id); 
        $flight->save();
    }

    Flight_meta::createMetas($flight);
     }
}