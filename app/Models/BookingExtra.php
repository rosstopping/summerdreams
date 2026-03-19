<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookingExtra extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relations
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }
    
    public function extra()
    {
        return $this->belongsTo('App\Models\Extra');
    }
}
