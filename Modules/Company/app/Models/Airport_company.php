<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Airport_company extends Model
{
    public $timestamps = false;
    
    public $table = 'airport_company';

    protected $guarded = [];

    public static function createAirportCompany($companyId, $airportId)
    {
        self::create([
            'company_id' => $companyId,
            'airport_id' => $airportId
        ]);
    }
    public static function deleteAirportCompany($airportId, $companyId)
    {
        self::where([
            'company_id' => $companyId,
            'airport_id' => $airportId
            ])->delete();
    }
}
