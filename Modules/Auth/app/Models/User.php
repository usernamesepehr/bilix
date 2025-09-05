<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Booking\Models\Book;
use Modules\Company\Models\Company;
use Tymon\JWTAuth\Contracts\JWTSubject;

// use Tymon\JWTAuth\Contracts\JWTSubject;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Auth\Database\Factories\UserFactory;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}

