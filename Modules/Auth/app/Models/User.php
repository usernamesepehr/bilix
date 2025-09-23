<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
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
     *
     */
    public $timestamps = false;
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
    public static function createUser(mixed $request, null|string $profilePath, string $timestamp, int $role = 0, null|int $companyId = null)
    {
        return self::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'city' => $request->city,
            'profile' => $profilePath ? asset('/storage/' . $profilePath) : null,
            'role' => $role,
            'company_id' => $companyId,
            'created_at' => $timestamp
        ]);
    }
    public static function updateUser($request, $userId)
    {
        self::where('id', $userId)->update($request->except('id', 'profile', 'role', 'company_id', 'created_at'));
    }
    public static function updateUserByAdmin($data, $userId)
    {
        static::where('id', $userId)->update(Arr::except($data, ['id', 'profile', 'created_at']));
    }
    public static function getCompanyIdById($id)
    {
        return self::select('company_id')->where('id', $id)->firstOrFail()->company_id;
    }
    public static function getByEmail($email)
    {
        return self::where('email', $email)->first();
    }
    public static function getPersonnel($id, $companyId)
    {
        return self::where(['id' => $id, 'company_id' => $companyId])->firstOrFail();
    }
    public static function getPersonnels($companyId)
    {
        return self::select('id', 'name', 'phone', 'profile')->where('company_id', $companyId)->get();
    }
    public static function deletePersonnel($id, $companyId)
    {
        self::where(['id' => $id, 'company_id' => $companyId])->delete();
    }
    public function getCreatedAtAttribute($value)
    {
        return jdate('Y F j', (int) $value);
    }
}

