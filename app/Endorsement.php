<?php

namespace App;

use Spatie\MediaLibrary\Media;
use Spatie\Image\Manipulations;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Endorsement extends Model implements HasMediaConversions
{
    use PimpableTrait;
    use HasMediaTrait;

    protected $sortParameterName = 'sort';
    public $searchable           = ['name'];
    public $sortable             = ['name', 'created_at'];
    protected $fillable          = [
        'name',
        'body',
    ];

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
            ->nonQueued();
    }
}
