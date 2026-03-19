<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

class Page extends Model implements HasMedia
{
    use HasFlexible;
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $casts = [
        'content' => 'array',
        'fields' => 'array',
        'seo' => 'array',
        'meta' => 'array',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function field($name)
    {
        return $this->fields()->whereSlug($name)->first();
    }

    public function image($name)
    {
        return $this->getFirstMedia($name);
    }

    public function images($name)
    {
        return $this->getMedia($name);
    }
    
    public function getFlexibleContentAttribute()
    {
        return $this->flexible('content', [
            'hero-slider' => \App\Nova\Flexible\Layouts\HeroSlider::class,
            'sliding-images' => \App\Nova\Flexible\Layouts\SlidingImages::class,
        ]);
    }
}
