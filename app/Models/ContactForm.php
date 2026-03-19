<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactForm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'site',
        'form_name',
        'name',
        'email',
        'message',
        'group_size',
        'arrival_date',
        'data',
        'crm'
    ];

    protected $casts = [
        'crm' => 'array',
        'data' => 'array',
        'arrival_date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Scope a query to only include CRM forms (Popup or Register).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCrm($query)
    {
        return $query->whereIn('form_name', ['Popup', 'PPC']);
    }

    public function scopeNotCrm($query)
    {
        return $query->whereNotIn('form_name', ['Popup', 'PPC']);
    }

    public function getCrmStatusAttribute()
    {
        return data_get($this->crm, 'status', 'new');
    }
}
