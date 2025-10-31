<?php

namespace Modules\Flight\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Flight\Services\OptionsExcelHandlerService;

use function Safe\ps_begin_page;

class OptionsImport implements ToCollection, WithHeadingRow {

    public function __construct(
        private array &$validated,
        private array &$failures
    ) {}
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            $result = OptionsExcelHandlerService::Validator((array) $row);

            if (is_array($result)) {
                $this->failures[] = [
                    'row' => $rowNumber,
                    'errors' => $result['errors']->messages(),
                    'sheet' => 'Options'
                ];
            } else {
                $this->validated[] = [
                    'handler' => OptionsExcelHandlerService::class,
                    'instance' => $result
                ];
            }
        }
    }
}