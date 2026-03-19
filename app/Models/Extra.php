<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $casts = [
        'group_prices' => 'array'
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class);
    }

    protected function deposit(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function getDepositPricesAttribute()
    {
        $prices = [];

        for ($i=1; $i < 100; $i++) { 
            $prices[$i] = $this->getDeposit($i);
        }

        return $prices;
    }

    public function getAmountPricesAttribute()
    {
        $prices = [];

        for ($i=1; $i < 100; $i++) { 
            $prices[$i] = $this->getAmount($i);
        }

        return $prices;
    }

    public function getDeposit($quantity = 1)
    {
        if ($this->amount_type === 'per_group_size') {
            foreach ($this->group_prices as $price) {
                if ($price['quantity'] == $quantity) return $price['deposit'];
            }

            return null;
        }

        if ($this->amount_type === 'per_guest') {
            return $this->deposit * $quantity;
        }

        if ($this->amount_type === 'fixed') {
            return $this->deposit;
        }

        return null;
    }

    public function getAmount($quantity = 1)
    {
        if ($this->amount_type === 'per_group_size') {
            foreach ($this->group_prices as $price) {
                if ($price['quantity'] === $quantity) return $price['amount'];
            }

            return null;
        }

        if ($this->amount_type === 'per_guest') {
            return $this->amount * $quantity;
        }

        if ($this->amount_type === 'fixed') {
            return $this->amount;
        }

        return null;
    }
}
