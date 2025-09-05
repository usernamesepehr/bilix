<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Booking\Models\Book_flight;
use Modules\Company\Models\Airport;
use Modules\Company\Models\Company;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Flight\Database\Factories\FlightFactory;

class Flight extends Model
{
    protected $guarded = [];

   public function origin()
    {
        return $this->belongsTo(Airport::class, 'origin_airport');
    }
    public function destination()
    {
        return $this->belongsTo(Airport::class, 'destination_airport');
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function options(): HasMany
    {
        return $this->hasMany(Flight_option::class);
    }
    public function metas(): HasMany
    {
        return $this->hasMany(Flight_meta::class);
    }
    public function book_flights(): HasMany
    {
        return $this->hasMany(Book_flight::class);
    }
}
