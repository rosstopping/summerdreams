<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Enums\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use SoftDeletes;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected $fillable = [
        'name',
        'amount',
        'currency',
        'deposit',
        'start_date',
        'repeat',
        'calendar_book_link',
        'secret'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'repeat_exclude_days' => 'array',
        'exclude_dates' => 'array',
        'extra_dates' => 'array',
        'sold_out_dates' => 'array',
        'seo' => 'array',
        'currency' => Currency::class,
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
    
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class);
    }
    
    public function upgrade(): HasOne
    {
        return $this->hasOne(Upgrade::class);
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

    public function dates($from = null, $to = null, $include_sold_out = false)
    {
        $event_end_date = $this->end_date ?: now()->addDays(365);

        $events = [];

        if (!$this->repeat) array_push($events, $this->start_date);

        if ($this->repeat === 'daily') {
            for ($i = 0; $i < $this->start_date->diffInDays($event_end_date); $i++) {
                $date = $this->start_date->copy()->addDays($i);
                /**
                 * Check the day isn't in exceptions
                 */
                if (!in_array($date->format('l'), data_get($this, 'repeat_exclude_days', []))) {
                    array_push($events, $date);
                }
            }
        }

        if ($this->repeat === 'weekly') {
            for ($i = 0; $i < $this->start_date->diffInWeeks($event_end_date); $i++) {
                array_push($events, $this->start_date->copy()->addWeeks($i));
            }
        }

        if ($this->repeat === 'monthly') {
            for ($i = 0; $i < $this->start_date->diffInMonths($event_end_date); $i++) {
                array_push($events, $this->start_date->copy()->addMonth($i));
            }
        }

        if ($this->repeat === 'yearly') {
            for ($i = 0; $i < $this->start_date->diffInYears($event_end_date); $i++) {
                array_push($events, $this->start_date->copy()->addYear($i));
            }
        }

        /**
         * Add any extra dates
         */
        foreach (data_get($this, 'extra_dates', []) as $extra_date) {
            if ($extra_date) {
                $extra_date = Carbon::createFromFormat('d/m/Y', $extra_date)->startOfDay();
                array_push($events, $extra_date);
            }
        }

        /**
         * Remove any dates to exclude
         */
        $events = collect($events)->filter(function($date) {
            return !in_array($date->format('d/m/Y'), data_get($this, 'exclude_dates', []));
        });

        /**
         * Remove any sold out dates
         */
        if (!$include_sold_out) {
            $events = collect($events)->filter(function($date) {
                return !in_array($date->format('d/m/Y'), data_get($this, 'sold_out_dates', []));
            });
        }

        /**
         * Only get events between $from & $to if set
         */
        if ($from) $events = $events->filter(fn ($date) => $date >= $from);
        if ($to) $events = $events->filter(fn ($date) => $date <= $to);

        return $events;
    }
}
