<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Auth\Models\User;

// use Modules\Company\Database\Factories\CompanyFactory;

class Company extends Model
{
    // use HasFactory;
    protected $guarded = [];
    public $table = 'companies';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
    public function metas(): HasMany
    {
        return $this->hasMany(Company_meta::class);
    }
    public function airports(): BelongsToMany
    {
        return $this->belongsToMany(Airport::class);
    }
    public function getCreatedAtAttribute($value)
    {
        return jdate('Y F j', (int) $value);
    }
}
