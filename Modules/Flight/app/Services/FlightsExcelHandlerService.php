<?php

namespace Modules\Flight\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Flight_meta;

class FlightsExcelHandlerService extends ExcelHandlerService {

     protected static $rules =[
         '1' => 'required|integer|min:1',
         '2' => 'required|string|max:50|unique:flights,number',
         '3' => 'required|string|max:100',
         '4' => 'sometimes|integer|between:0,100',
         '5' =>' required|exists:airports,id',
         '6' => 'required|exists:airports,id|different:5',
         '7' => 'sometimes|string|unique:flights,slug',
         '8' => 'required|string',
         '9' => 'required|string|regex:/^\d{2}:\d{2}$/',
         '10' => 'required|string|regex:/^\d{2}:\d{2}$/',
     ];
     protected static $messages =[
                    '1.required' => 'ظرفیت پرواز الزامی است.',
    '1.integer' => 'ظرفیت پرواز باید عددی باشد.',
    '1.min' => 'ظرفیت پرواز باید حداقل :min باشد.',

    '2.required' => 'شماره پرواز الزامی است.',
    '2.string' => 'شماره پرواز باید رشته‌ای باشد.',
    '2.max' => 'شماره پرواز نمی‌تواند بیش از :max کاراکتر باشد.',
    '2.unique'    => 'این شماره پرواز قبلاً ثبت شده است.',

    '3.required' => 'نام هواپیما الزامی است.',
    '3.string' => 'نام هواپیما باید رشته‌ای باشد.',
    '3.max' => 'نام هواپیما نمی‌تواند بیش از :max کاراکتر باشد.',

    '4.integer' => 'درصد تخفیف باید عددی باشد.',
    '4.between' => 'درصد تخفیف باید بین :min تا :max باشد.',

    '5.required' => 'فرودگاه مبدا الزامی است.',
    '5.exists' => 'فرودگاه مبدا انتخاب‌شده معتبر نیست.',

    '6.required' => 'فرودگاه مقصد الزامی است.',
    '6.exists' => 'فرودگاه مقصد انتخاب‌شده معتبر نیست.',
    '6.different' => 'فرودگاه مقصد باید با فرودگاه مبدا متفاوت باشد.',

    '7.sometimes' => 'مقدار slug باید در صورت وجود بررسی شود.',
    '7.string' => 'slug باید رشته‌ای باشد.',
    '7.unique' => 'این slug قبلاً برای یک پرواز دیگر ثبت شده است.',

    '8.required' => 'زمان شروع پرواز الزامی است.',
    '8.string' => 'زمان شروع پرواز باید به صورت رشته باشد.',
    '8.regex' => 'زمان شروع پرواز باید در قالب HH:MM وارد شود.',

    '9.required' => 'زمان پایان پرواز الزامی است.',
    '9.string' => 'زمان پایان پرواز باید به صورت رشته باشد.',
    '9.regex' => 'زمان پایان پرواز باید در قالب HH:MM وارد شود.',

    '10.required' => 'تاریخ پرواز الزامی است.',
    '10.string' => 'تاریخ پرواز باید به صورت متن (رشته) وارد شود.',
     ];
     public static function Validator($data): array|ExcelHandlerService
     {
        $validator = Validator::make($data, self::$rules, self::$messages);

        if ($validator->fails()) {
           return ['errors' => $validator->errors()];
        } 

        return new self($validator->validated());
     }

     public static function Create(ExcelHandlerService $excelHandlerService, ...$args): void
     {
          $flight = Flight::create([
        'load' => $excelHandlerService->validated[1],
        'number' => $excelHandlerService->validated[2],
        'plane' => $excelHandlerService->validated[3],
        'discount' => $excelHandlerService->validated[4],
        'origin_airport' => $excelHandlerService->validated[5],
        'destination_airport' => $excelHandlerService->validated[6],
        'company_id' => $args['company_id'],
        'slug' => $excelHandlerService->validated[7], 
        'date' => $excelHandlerService->validated[10],
        'timeStart' => $excelHandlerService->validated[8],
        'timeEnd' => $excelHandlerService->validated[9],
        ]);
    
    if(empty($flight->slug)){
        $flight->slug = Str::slug($flight->number . '-' . $flight->id); 
        $flight->save();
    }

    Flight_meta::createMetas($flight);
     }
}