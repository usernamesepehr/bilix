<?php


namespace Modules\Flight\Services;

abstract class ExcelHandlerService {


    protected function __construct(protected array $validated) {}

    abstract protected static array $rules = [];
    abstract protected static array $messages = [];
    abstract public static function Validator($data): array|ExcelHandlerService;

    abstract public static function Create(ExcelHandlerService $excelHandlerService, ...$args): void;
}