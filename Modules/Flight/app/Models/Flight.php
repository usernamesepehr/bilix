<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Booking\Models\Book_flight;
use Modules\Company\Models\Airport;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\In;
use Modules\Company\Models\Company;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Flight\Database\Factories\FlightFactory;

class Flight extends Model
{
    protected $guarded = [];

    public $timestamps = false;

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
    public function FlightOptions(): HasMany
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
    public static function createFlight($request, $companyId)
    {
       $flight = self::create([
        'load' => $request->load,
        'number' => $request->number,
        'plane' => $request->plane,
        'discount' => $request->discount,
        'origin_airport' => $request->origin_airport,
        'destination_airport' => $request->destination_airport,
        'company_id' => $companyId,
        'slug' => $request->slug, 
        'date' => $request->date,
        'timeStart' => $request->timeStart,
        'timeEnd' => $request->timeEnd
        ]);
    
    if(empty($flight->slug)){
        $flight->slug = Str::slug($flight->number . '-' . $flight->id); 
        $flight->save();
    }

    return $flight;
    }
    public static function findOneBySlug($slug)
    {
        return static::where('slug', $slug)->with(['origin', 'destination', 'company', 'FlightOptions', 'metas'])->firstOrFail();
    }
    public static function deleteFlight(int $id, int $companyId): void
    {
        static::where(['id' => $id, 'company_id' => $companyId])->delete();
    }
}
