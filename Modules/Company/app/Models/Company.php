<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Auth\Models\User;
use Illuminate\Support\Str;
use PDPhilip\ElasticLens\Indexable;


// use Modules\Company\Database\Factories\CompanyFactory;

class Company extends Model
{
    use Indexable;

    public static $searchableIndex = "name";
    public $timestamps = false;
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
    public static function createCompany(mixed $request, string $timestamp, string $logoPath)
    {
        $company = static::create([
            'name' => $request->name,
            'description' => $request->description,
            'registerNumber' => $request->registerNumber,
            'address' => $request->address,
            'slug' => $request->slug,
            'logo' => $logoPath ? asset('/storage/' . $logoPath) : null,
            'created_at' => $timestamp,
        ]);

        if(empty($company->slug)){
        $company->slug = Str::slug($company->id . '-' . $company->name); 
        $company->save();
        return $company;
    }

    }
    public static function updateCompany($request, $id): void
    {
        self::where('id', $id)->update($request->except('id', 'slug', 'created_at', 'logo'));
    }
}
