<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Company\Database\Factories\CertificatesFactory;

class Certificate extends Model
{
    // use HasFactory;

    protected $guarded = [];
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
