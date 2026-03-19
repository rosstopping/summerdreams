<?php

namespace App\Models;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Package extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'amount',
        'deposit',
        'includes',
        'currency',
        'secret'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected $casts = [
        'includes' => 'array',
        'currency' => Currency::class,
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
    
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
    
    public function upgrade(): HasOne
    {
        return $this->hasOne(Upgrade::class);
    }

    public function seasonalPricings(): HasMany
    {
        return $this->hasMany(SeasonalPricing::class);
    }

    /**
     * Get the amount for a specific date, considering seasonal pricing
     * 
     * @param mixed $date Carbon date instance, date string, or null
     * @return float The amount for the given date, or default package amount if no date or no seasonal pricing found
     */
    public function getAmountForDate($date = null)
    {
        if ($date) {
            $seasonalPricing = SeasonalPricing::getForPackageAndDate($this->id, $date);
            if ($seasonalPricing) {
                return $seasonalPricing->amount;
            }
        }
        return $this->amount;
    }

    /**
     * Get the deposit for a specific date, considering seasonal pricing
     * 
     * @param mixed $date Carbon date instance, date string, or null
     * @return float|null The deposit for the given date, or default package deposit if no date or no seasonal pricing found
     */
    public function getDepositForDate($date = null)
    {
        if ($date) {
            $seasonalPricing = SeasonalPricing::getForPackageAndDate($this->id, $date);
            if ($seasonalPricing && $seasonalPricing->deposit) {
                return $seasonalPricing->deposit;
            }
        }
        return $this->deposit;
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

    protected function discount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->events->sum('amount') - $this->amount,
        );
    }
}
