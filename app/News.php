<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\MediaLibrary\Media;
use Spatie\Image\Manipulations;
use Spatie\Sluggable\SlugOptions;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class News extends Model implements HasMediaConversions
{
    use HasSlug;
    use PimpableTrait;
    use HasMediaTrait;

    protected $sortParameterName = 'sort';
    public $searchable           = ['title'];
    public $sortable             = ['title', 'created_at'];
    protected $fillable          = [
        'title',
        'slug',
        'body',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->fit(Manipulations::FIT_CONTAIN, 200, 200)
            ->crop(Manipulations::CROP_CENTER, 200, 200)
            ->nonQueued();

        $this->addMediaConversion('crop')
            ->width(700)
            ->height(300)
            ->fit(Manipulations::FIT_CONTAIN, 700, 300)
            ->crop(Manipulations::CROP_CENTER, 700, 300)
            ->nonQueued();

        $this->addMediaConversion('full')
            ->width(900)
            ->nonQueued();
    }
}
