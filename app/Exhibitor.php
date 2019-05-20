<?php

namespace App;

use Spatie\MediaLibrary\Media;
use Spatie\Image\Manipulations;
use Spatie\Sluggable\SlugOptions;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Exhibitor extends Model implements HasMediaConversions
{
    use PimpableTrait;
    use HasMediaTrait;

    protected $sortParameterName = 'sort';
    public $searchable           = ['name'];
    public $sortable             = [];
    protected $fillable          = [
        'name',
        'email',
        'phone',
        'fax',
        'country_id',
        'video',
        'categories',
        'address',
        'description',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'categories' => 'array',
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
            ->fit(Manipulations::FIT_FILL, 200, 200)
            ->nonQueued();

        $this->addMediaConversion('full')
            ->width(500)
            ->height(500)
            ->fit(Manipulations::FIT_FILL, 500, 500)
            ->performOnCollections('logo')
            ->nonQueued();
    }

    public function exhibitions()
    {
        return $this->belongsToMany('App\Exhibition', 'exhibition_exhibitors', 'exhibitor_id', 'exhibition_id')
            ->withPivot('booth');
    }

    public function country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }
}
