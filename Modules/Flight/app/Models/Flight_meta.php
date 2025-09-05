<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Flight\Database\Factories\FlightMetaFactory;

class Flight_meta extends Model
{
    protected $guarded = [];

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
}
