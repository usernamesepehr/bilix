<?php

namespace Modules\Flight\Services;

use Illuminate\Support\Facades\Validator;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Flight_option;

class OptionsExcelHandlerService extends ExcelHandlerService {
     protected static $rules =[
         '1' => 'required|integer|min:1',
         '2' => 'required|string|exists:flights,number',
         '3' => 'required|array',
         '3.*' => 'exists:options,id', 
         '4' => 'required|string',
     ];
     protected static $messages = [
      '1.required' => 'تعداد برای هر گزینه الزامی است.',
      '1.integer' => 'تعداد باید عدد صحیح باشد.',
      '1.min' => 'تعداد باید حداقل 1 باشد.',
      '2.required' => 'وارد کردن شماره پرواز الزامی است',
      '2.string' => 'شماره پرواز باید از نوع رشته ای باشد ',
      '3.exists' => 'شماره پرواز وارد شده معتبر نیست',
      '3.required' => 'شناسه گزینه‌ها برای هر گزینه الزامی است.',
      '3.array' => 'شناسه گزینه‌ها باید آرایه باشد.',
      '3.*.exists' => 'یکی از گزینه‌های انتخاب شده معتبر نیست.',
      '4.required' => 'قیمت برای هر گزینه الزامی است.',
      '4.string' => 'قیمت باید رشته باشد.',
     ];
     public static function Validator($data): array|ExcelHandlerService
     {
        $validator = Validator::make($data, self::$rules, self::$messages);
        
        if ($validator->fails()) {
         return ['sheet' => 'options', 'errors' => $validator->errors()];
        } 

        return new self([]);
     }

     public static function Create(ExcelHandlerService $excelHandlerService, ...$args): void
     {
         $flightId = Flight::select('id')->where('number', $excelHandlerService->validated[2])->firstOrFail();

         Flight_option::create([
            'flight_id' => $flightId,
            'quantity' => $excelHandlerService->validated[1],
            'options_id' => $excelHandlerService->validated[3],
            'price' => $excelHandlerService->validated[4],
        ]);
     }
}