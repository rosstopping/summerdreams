<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public $fillable = [
        'key',
        'name',
        'value',
        'field',
    ];
    
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(fn () => Cache::flush());
        static::updated(fn () => Cache::flush());
    }

    public function scopeKey($query, $key)
    {
        return data_get($query->where('key', $key)->first(), 'value', '');
    }
}
