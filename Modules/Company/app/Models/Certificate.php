<?php

namespace Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Company\Database\Factories\CertificatesFactory;

class Certificate extends Model
{
    // use HasFactory;
    public $timestamps = false;

    protected $guarded = [];
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public static function createCertificate($request, $photoPath, $companyId)
    {
        self::create([
            'title' => $request->title,
            'issuer' => $request->issuer,
            'photo' => asset('/storage/' . $photoPath),
            'company_id' => $companyId
        ]);
    }
    public static function deleteCertificate($id, $companyId)
    {
         self::where([
            'company_id' => $companyId,
            'id' => $id
            ])->delete();
    }
}
