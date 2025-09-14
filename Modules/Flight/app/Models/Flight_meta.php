<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Flight\Database\Factories\FlightMetaFactory;

class Flight_meta extends Model
{
    protected $guarded = [];
    public $timestamps = false;


    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
    public static function createMetas($flight)
    {
        self::create(['name' => 'number', 'value' => $flight->number, 'flight_id' => $flight->id]);
        self::create(['name' => 'canonical', 'value' => asset('/flight/' . $flight->slug), 'flight_id' => $flight->id]);
    }
}
