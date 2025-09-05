<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Flight\Models\Flight;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Booking\Database\Factories\BookFlightFactory;

class Book_flight extends Model
{
    protected $guarded = [];
    
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
}
