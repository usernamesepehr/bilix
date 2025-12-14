<?php


namespace Modules\Flight\Services;

abstract class ExcelHandlerService {


    protected function __construct(protected array $validated) {}

    abstract protected static function rules(): array;
    abstract protected static function messages(): array;
    abstract public static function Validator($data);

    abstract public static function Create(ExcelHandlerService $excelHandlerService, ...$args): void;
}