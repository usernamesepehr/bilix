<?php

namespace Modules\Flight\Services;

use Illuminate\Support\Facades\Validator;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Flight_option;

class OptionsExcelHandlerService extends ExcelHandlerService {
     protected static function rules(): array
     {
     return [
         'quantity' => 'required|integer|min:1',
         'number' => 'required|string|exists:flights,number',
         'options_id' => 'required|array',
         'options_id.*' => 'exists:options,id', 
         'price' => 'required|string',
     ];
    }
     protected static function messages(): array
     {
     return [
      'quantity.required' => 'تعداد برای هر گزینه الزامی است.',
      'quantity.integer' => 'تعداد باید عدد صحیح باشد.',
      'quantity.min' => 'تعداد باید حداقل 1 باشد.',
      'number.required' => 'وارد کردن شماره پرواز الزامی است',
      'number.string' => 'شماره پرواز باید از نوع رشته ای باشد ',
      'number' => 'شماره پرواز مورد نظر معتبر نیست',
      'number.exists' => 'شماره پرواز وارد شده معتبر نیست',
      'options_id.required' => 'شناسه گزینه‌ها برای هر گزینه الزامی است.',
      'options_id.array' => 'شناسه گزینه‌ها باید آرایه باشد.',
      'options_id.*.exists' => 'یکی از گزینه‌های انتخاب شده معتبر نیست.',
      'price.required' => 'قیمت برای هر گزینه الزامی است.',
      'price.string' => 'قیمت باید رشته باشد.',
     ];
     }
     public static function Validator($data): array|ExcelHandlerService
     {
        $validator = Validator::make($data["\x00*\x00items"], self::rules(), self::messages());
        
        if ($validator->fails()) {
         return ['sheet' => 'options', 'errors' => $validator->errors()];
        } 

        return new self([]);
     }

     public static function Create(ExcelHandlerService $excelHandlerService, ...$args): void
     {
         $flightId = Flight::select('id')->where('number', $excelHandlerService->validated[2])->first();
         if($flightId) {
             
         Flight_option::create([
            'number' => $flightId,
            'quantity' => $excelHandlerService->validated['quantity'],
            'options_id' => $excelHandlerService->validated['options_id'],
            'price' => $excelHandlerService->validated['price'],
        ]);
         }

     }
}