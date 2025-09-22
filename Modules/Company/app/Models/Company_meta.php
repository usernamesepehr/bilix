<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Company\Database\Factories\CompanyMetasFactory;

class Company_meta extends Model
{
    public $timestamps = false;
    // use HasFactory;
    protected $guarded = [];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public static function createMetas($company)
    {
        static::create(['name' => 'number', 'value' => $company->name, 'company_id' => $company->id]);
        static::create(['name' => 'number', 'value' => $company->description, 'company_id' => $company->id]);
        static::create(['name' => 'canonical', 'value' => asset('/company/' . $company->slug), 'company_id' => $company->id]);
    }
}
