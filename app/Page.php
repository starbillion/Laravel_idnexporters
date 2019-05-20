<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasSlug;
    use PimpableTrait;

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
}
