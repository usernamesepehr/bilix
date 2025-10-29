<?php


namespace Modules\Flight\Services;

abstract class ExcelHandlerService {
    protected array $validated;

    protected function __construct(array $validated) {
         $this->validated = $validated;
    }

    abstract protected static array $rules = [];
    abstract protected static array $messages = [];
    abstract public static function Validator($data): array|ExcelHandlerService;

    abstract public static function Create(ExcelHandlerService $data): void;
}