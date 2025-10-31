<?php 


namespace Modules\Flight\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Modules\Flight\Services\FlightsExcelHandlerService;

class FlightImport implements ToCollection, WithHeadingRow{

     public function __construct(
          private int $company_id,
          private array &$validated,
          private array &$failures
     ) {}
     public function collection(Collection $rows) 
     {
          foreach ($rows as $index => $row) {
               $rowNumber = $index + 2;
               $result = FlightsExcelHandlerService::Validator((array)$row);
               if (is_array($result)) {
                $this->failures[] = [
                    'row' => $rowNumber,
                    'errors' => $result['errors']->messages(),
                    'sheet' => 'Flights'
                ];
            } else {
                $this->validated[] = [
                    'handler' => FlightsExcelHandlerService::class,
                    'instance' => $result
                ];
            }
          }
     }
}