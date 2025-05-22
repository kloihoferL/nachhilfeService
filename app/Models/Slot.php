<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slot extends Model
{
    protected $fillable = ['start_time', 'end_time', 'offer_id'];

    //ein slot gehört zu einem Angebot
    public function offer():BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    //ein slot gehört zu einer Buchung
    /*public function booking():BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }*/



}
