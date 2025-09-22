<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

// use Modules\Company\Database\Factories\AirportsFactory;

class Airport extends Model
{
    public $timestamps = false;
    // use HasFactory;

    protected $guarded = [];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
    public function getCreatedAtAttribute($value)
    {
        return jdate('Y F j', (int) $value);
    }
    public static function createAirport(mixed $request, string $timestamp)
    {
        $airport = static::create([
            'name' => $request->name,
            'city' => $request->city,
            'iata' => $request->iata,
            'slug' => $request->slug,
            'created_at' => $timestamp
        ]);
        if(empty($airport->slug)){
        $airport->slug = Str::slug($airport->id . '-' . $airport->name); 
        $airport->save();
        }
    }
    public static function updateAirport(mixed $request)
    {
        static::where('id', $request->id)->update($request->except('id', 'created_at', 'slug'));
    }
}
