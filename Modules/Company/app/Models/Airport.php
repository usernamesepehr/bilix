<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// use Modules\Company\Database\Factories\AirportsFactory;

class Airport extends Model
{
    // use HasFactory;

    protected $guarded = [];

     public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
