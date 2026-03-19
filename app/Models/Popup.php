<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

class Popup extends Model implements HasMedia
{
    use HasFlexible;
    use HasFactory;
    use InteractsWithMedia;

    protected $casts = [
        'flexible_content' => 'array',
        'pages' => 'array',
        'data' => 'array',
    ];
    
    public function getFlexibleContentAttribute()
    {
        return $this->flexible('flexible_content');
    }
}
