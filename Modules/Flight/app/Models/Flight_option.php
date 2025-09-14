<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Flight\Database\Factories\FlightOptionFactory;

class Flight_option extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
    public static function createOption($option, $flightId)
    {
        self::create([
            'flight_id' => $flightId,
            'quantity' => $option->quantity,
            'options_id' => json_encode($option->options_id),
            'price' => $option->price,
        ]);
    }
}
