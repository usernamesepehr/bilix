<?php

namespace Modules\Flight\Services;

class OptionsExcelHandlerService extends ExcelHandlerService {
     protected $rules =[];
     protected $messages =[];
     public static function Validator($data): array|ExcelHandlerService
     {
        return new self([]);
     }

     public static function Create(ExcelHandlerService $data): void
     {
        
     }
}