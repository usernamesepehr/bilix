<?php 

namespace Modules\Flight\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Validators\ValidationException;


class FlightMultiSheetImport implements WithMultipleSheets {


    private array $failures = [];
    private array $validated = [];
    public function __construct(private int $company_id) {}
    public function sheets(): array 
    {
        return [
            'Flights' => new FlightImport($this->company_id, $this->validated, $this->failures),
            'Options' => new OptionsImport($this->validated, $this->failures),
        ];
    }

    public function __destruct()
    {
        if (!empty($this->failures)) {
            // throw new ValidationException( $this->failures);
            throw ValidationException::withMessages($this->failures);
        }

        DB::transaction(function () {
            foreach ($this->validated as $item) {
                $item['handler']::create($item['instance'], $this->company_id);
            }
        });
    }
}