<?php

namespace App;

use Carbon\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\MediaLibrary\Media;
use Spatie\Image\Manipulations;
use Spatie\Sluggable\SlugOptions;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Exhibition extends Model implements HasMediaConversions
{
    use HasSlug;
    use PimpableTrait;
    use HasMediaTrait;

    protected $sortParameterName = 'sort';
    public $searchable           = ['title', 'organizer', 'venue'];
    public $sortable             = ['title', 'organizer', 'venue', 'featured', 'created_at'];
    protected $fillable          = [
        'country_id',
        'title',
        'slug',
        'start_at',
        'ending_at',
        'venue',
        'organizer',
        'body',
        'featured',
        'calendar',
        'color',
        'directory',
    ];
    protected $dates = [
        'start_at',
        'ending_at',
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = null;

        if ($value) {
            $date                         = Carbon::createFromFormat('d-m-Y', $value);
            $this->attributes['start_at'] = $date;
        }
    }

    public function setEndingAtAttribute($value)
    {
        $this->attributes['ending_at'] = null;

        if ($value) {
            $date                          = Carbon::createFromFormat('d-m-Y', $value);
            $this->attributes['ending_at'] = $date;
        }
    }

    public function country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }

    public function exhibitors()
    {
        return $this->belongsToMany('App\Exhibitor', 'exhibition_exhibitors', 'exhibition_id', 'exhibitor_id');
    }
}
