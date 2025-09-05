<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Auth\Models\User;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Booking\Database\Factories\BookFactory;

class Book extends Model
{
    protected $guarded = [];

    public function book_flight(): HasOne
    {
        return $this->hasOne(Book_flight::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
