<?php

namespace App\Models;

use App\Mail\BookingConfirmationMail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Booking extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'site',
        'name',
        'email',
        'mobile',
        'arrival_date',
        'session_id',
        'enquired_at'
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'dates' => 'array',
        'confirmed_at' => 'datetime',
        'enquired_at' => 'datetime',
        'paying_at' => 'datetime',
        'deposit_checkout' => 'boolean'
    ];

    public function extras()
    {
        return $this->belongsToMany(Extra::class)->using(BookingExtra::class)->withPivot(['quantity', 'date']);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scheduled_payments()
    {
        return $this->hasMany(Payment::class)->whereNotNull('scheduled_at')->whereNull('confirmed_at');
    }
    
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class);
    }
    
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
    
    public function upgrade(): BelongsTo
    {
        return $this->belongsTo(Upgrade::class);
    }
    
    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class);
    }
    
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
    
    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    protected function reference(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => config('app.prefix', 'SD') . $value,
            set: fn ($value) => $value,
        );
    }

    protected function amount(): Attribute
    {
        // Calculate package amounts considering seasonal pricing
        $packageAmount = 0;
        foreach ($this->packages as $package) {
            $packageAmount += $package->getAmountForDate($this->arrival_date);
        }
        
        $amount = $this->events->sum('amount') + $packageAmount + $this->upgrade?->amount;

        if ($this->discount) {
        
            /**
             * Get deposit amount to work out any discount
             */
            $packageDeposit = 0;
            foreach ($this->packages as $package) {
                $packageDeposit += $package->getDepositForDate($this->arrival_date);
            }
            
            $depositAmount = $this->events->sum('deposit') + $packageDeposit;

            if ($this->upgrade?->deposit) {
                $depositAmount = $this->upgrade?->deposit;
            }

            $discountAmount = $this->discount->amount;
            if ($this->discount->percentage) {
                $discountAmount = ($depositAmount / 100) * $this->discount->amount;
            } elseif (data_get($this->discount, 'type', 'per_booking') === 'per_guest') {
                $discountAmount = $discountAmount * $this->guests;
            }

            $amount = $amount - $discountAmount;
        }

        $amount = $amount * $this->guests;

        foreach ($this->extras as $extra) {
            $amount += $extra->getAmount($extra->pivot->quantity);
        }

        return Attribute::make(
            get: fn ($value) => $amount,
        );
    }

    protected function amountWithFee(): Attribute
    {
        $fee = setting('booking_fee') * $this->guests;

        return Attribute::make(
            get: fn ($value) => $this->amount + $fee,
        );
    }

    protected function deposit(): Attribute
    {
        // Calculate package deposits considering seasonal pricing
        $packageDeposit = 0;
        foreach ($this->packages as $package) {
            $packageDeposit += $package->getDepositForDate($this->arrival_date);
        }
        
        $depositAmount = $this->events->sum('deposit') + $packageDeposit;

        if ($this->upgrade?->deposit) {
            $depositAmount = $this->upgrade?->deposit;
        }

        if ($depositAmount > 0 && $this->discount) {
            $discountAmount = $this->discount->amount;
            if ($this->discount->percentage) {
                $discountAmount = ($depositAmount / 100) * $this->discount->amount;
            } elseif (data_get($this->discount, 'type', 'per_booking') === 'per_guest') {
                $discountAmount = $discountAmount * $this->guests;
            }
            $depositAmount = $depositAmount - $discountAmount;
        }

        $depositAmount = $depositAmount * $this->guests;
        
        foreach ($this->extras as $extra) {
            $depositAmount += $extra->getDeposit($extra->pivot->quantity);
        }

        return Attribute::make(
            get: fn ($value) => $depositAmount,
        );
    }

    protected function currency(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => data_get($this->payments->first(), 'currency', 'gbp'),
        );
    }

    public function getBalanceAttribute()
    {
        $amount = $this->amountWithFee;
        
        return number_format($amount - $this->total_paid, 2);
    }

    public function getBalanceWithoutFormattingAttribute()
    {
        $amount = $this->amountWithFee;
        
        return $amount - $this->total_paid;
    }

    public function getBalancingPaymentAmountWithoutFormattingAttribute()
    { 
        $balance = $this->balance_without_formatting;

        /**
         * Less any extras
         */
        if ($this->extras->count() > 0) {
            $balance = $balance - $this->extras->sum(function ($extra) {
                return $extra->getAmount($extra->pivot->quantity);
            });
        }

        $balancingPaymentAmount = $balance * 0.5;
        $totalPaid = $this->total_paid;

        // If they've already paid at least 50% of the current balance, return 0
        if ($totalPaid >= $balancingPaymentAmount) {
            return 0;
        }

        // Otherwise, return balancing payment
        return $balancingPaymentAmount;
    }

    public function getBalancingPaymentAmountAttribute()
    { 
        return number_format($this->balancing_payment_amount_without_formatting, 2);
    }

    public function getBalanceLess50Attribute()
    {
        $balance = $this->balance;

        if ($balance <= 50) return 0;

        return $balance - 50;
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()->confirmed()->get()->sum('amount');
    }

    public function getEnquiryStatusAttribute($value)
    {
        if (!$value) return 'new';

        return $value;
    }

    public function scopeConfirmed(Builder $query): void
    {
        $query->whereNotNull('confirmed_at');
    }

    public function scopeEnquiry(Builder $query): void
    {
        $query->whereNotNull('enquired_at')->whereNull('confirmed_at');
    }

    public function scopeIncomplete(Builder $query): void
    {
        $query->whereNull('confirmed_at')->whereNull('enquired_at');
    }

    public function createPaymentSchedule()
    {
        /**
         * Delete any scheduled payments that haven't been paid
         */
        $this->payments()->whereNotNull('scheduled_at')->whereNull('confirmed_at')->delete();

        /**
         * First payment is deposit, due immediatley
         */
        $this->payments()->create([
            'amount' => 1 * $this->guests,
            'scheduled_at' => now(),
            'reminder_sent_at' => now()
        ]);

        /**
         * Final payment
         */
        $this->payments()->create([
            'amount' => $this->deposit,
            'scheduled_at' => now()->addWeeks(2)->setTimeFromTimeString('09:00:00')
        ]);

        return $this->scheduled_payments;
    }

    public function availableEventDates()
    {
        if (!$this->arrival_date) return collect();

        $events = $this->events->merge($this->packages->pluck('events')->flatten());

        foreach ($events as $event) {
            $from = $this->arrival_date;
            if (!$event->allow_same_day) $from = $this->arrival_date->copy()->addDay();

            $departure_date = $this->arrival_date->copy()->addDays(7);
            if ($event->allow_same_day) $departure_date = $this->arrival_date->copy()->addDays(6);

            $event->dates = $event->dates(from: $from, to: $departure_date);
        }

        $dates = collect();

        $events = $events->sortBy(function ($event) {
            return $event->dates->count();
        });

        for ($i=0; $i < 8; $i++) {
            $current_day = $this->arrival_date->copy()->addDays($i);
            foreach ($events as $event) {
                /**
                 * Check to see if event is already in the list
                 */
                if (!$dates->contains('name', $event->name)) {
                    /**
                     * See if this day is within the dates array
                     */
                    foreach ($event->dates as $available_date) {
                        if ($available_date->format('d-m-Y') === $current_day->format('d-m-Y')) {

                            $found_dates = $dates->where('date', $available_date);

                            if ($found_dates->count() === 0) {
                                $dates->push([
                                    'name' => $event->name,
                                    'date' => $available_date,
                                    'duration' => $event->duration
                                ]);
                            }

                            if ($found_dates->count() === 1) {
                                $found_date = $found_dates->first();
                            
                                if (
                                    $event->duration === 'daytime' && $found_date['duration'] === 'nighttime'
                                    || $event->duration === 'nighttime' && $found_date['duration'] === 'daytime'
                                ) {
                                    $dates->push([
                                        'name' => $event->name,
                                        'date' => $available_date,
                                        'duration' => $event->duration
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $dates->sortBy('date');
    }

    public function selectDateOptions()
    {
        return $this->availableEventDates()
            ->groupBy('name')
            ->filter(function ($event) {
                return $event->count() > 1;
            });
    }

    public function generateReference()
    {
        $reference = mt_rand(100000, 999999);

        if (Booking::where('reference', $reference)->withTrashed()->first()) {
            return $this->generateReference();
        }

        return $reference;
    }
}
