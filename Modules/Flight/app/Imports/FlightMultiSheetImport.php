<?php 

namespace Modules\Flight\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class FlightMultiSheetImport implements WithMultipleSheets {
    public function sheets(): array 
    {
        return [
            'Flights' => new FlightImport(),
            'Options' => new OptionsImport(),
        ];
    }
}