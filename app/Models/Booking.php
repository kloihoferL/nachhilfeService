<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = ['giver_id', 'receiver_id', 'offer_id', 'slot_id'];

    public function giver():BelongsTo
    {
        return $this->belongsTo(User::class, 'giver_id');
    }

    public function receiver():BelongsTo{
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function offer():BelongsTo{
        return $this->belongsTo(Offer::class);
    }
}
