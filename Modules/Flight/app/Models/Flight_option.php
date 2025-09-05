<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Flight\Database\Factories\FlightOptionFactory;

class Flight_option extends Model
{
    protected $guarded = [];
    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
}
