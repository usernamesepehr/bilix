<?php

namespace Modules\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Auth\Models\User;

// use Modules\Support\Database\Factories\MessageFactory;

class Message extends Model
{
   protected $guarded = [];

   public $timestamps = false;

   public function sender(): BelongsTo
   {
      return $this->belongsTo(User::class, "sender_id");
   }

   public function reciever(): BelongsTo
   {
      return $this->belongsTo(User::class, "reciever_id");
   }

   public function parent(): BelongsTo
   {
    return $this->belongsTo(Message::class, "parent_id");
   }

   public function children(): HasMany
   {
    return $this->hasMany(Message::class, "parent_id");
   }

   public function getCreatedAtAtrribute(Int $value)
   {
    return jdate("Y F j" , $value);
   }

}
