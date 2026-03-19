<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upgrade extends Model
{
    use SoftDeletes;

    protected $casts = [
        'includes' => 'array'
    ];
    
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    protected function deposit(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }
}
