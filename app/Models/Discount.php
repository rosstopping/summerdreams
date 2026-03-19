<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }
}
