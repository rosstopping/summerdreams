<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Referral extends Model
{
    use SoftDeletes;
    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    
    public function enquiries(): HasMany
    {
        return $this->hasMany(Booking::class)->enquiry();
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function commissionFixed(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    protected function link(): Attribute
    {
        return Attribute::make(
            get: fn () => route('book.referral', $this),
        );
    }
}
