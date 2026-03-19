<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $fillable = [
        'booking_id',
        'amount',
        'reference',
        'customer_id',
        'payment_method_id',
        'metadata',
        'extra_data',
        'scheduled_at',
        'attempts',
        'confirmed_at',
        'currency',
        'method',
        'checked'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
        'extra_data' => 'array',
        'scheduled_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountAttribute($value)
    {
        return $value / 100;
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }

    public function scopeConfirmed($query)
    {
        return $query->whereNotNull('confirmed_at');
    }

    public function generateReference()
    {
        $reference = uniqid();

        if (Payment::where('reference', $reference)->first()) {
            return $this->generateReference();
        }

        return $reference;
    }
}
