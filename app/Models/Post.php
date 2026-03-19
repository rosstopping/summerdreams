<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

class Post extends Model implements HasMedia
{
    use HasFlexible;
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    /**
     * Get the options for generating the slug.
     */
    // public function getSlugOptions() : SlugOptions
    // {
    //     return SlugOptions::create()
    //         ->generateSlugsFrom('title')
    //         ->saveSlugsTo('slug');
    // }

    public $fillable = [
        'title',
        'excerpt',
        'content'
    ];

    public $casts = [
        'flexible_content' => 'array',
        'seo' => 'array'
    ];
    
    public function getFlexibleContentAttribute()
    {
        return $this->flexible('flexible_content', [
            'hero-slider' => \App\Nova\Flexible\Layouts\HeroSlider::class,
            'sliding-images' => \App\Nova\Flexible\Layouts\SlidingImages::class,
        ]);
    }
}
