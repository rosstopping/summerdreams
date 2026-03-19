<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeasonalPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'start_date',
        'end_date',
        'amount',
        'deposit',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
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
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value ? $value * 100 : null,
        );
    }

    /**
     * Check if this seasonal pricing is active for a given date
     */
    public function isActiveForDate($date): bool
    {
        $checkDate = is_string($date) ? \Carbon\Carbon::parse($date) : $date;
        return $checkDate->between($this->start_date, $this->end_date, true);
    }

    /**
     * Get the seasonal pricing for a specific date
     */
    public static function getForPackageAndDate($packageId, $date): ?self
    {
        $checkDate = is_string($date) ? \Carbon\Carbon::parse($date) : $date;
        
        return static::where('package_id', $packageId)
            ->where('start_date', '<=', $checkDate)
            ->where('end_date', '>=', $checkDate)
            ->first();
    }
}
