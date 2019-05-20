<?php

namespace App;

use Spatie\MediaLibrary\Media;
use Spatie\Image\Manipulations;
use Hootlex\Moderation\Moderatable;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use JordanMiguel\LaravelPopular\Traits\Visitable;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class ProductPost extends Model implements HasMediaConversions
{
    use PimpableTrait;
    use SoftDeletes;
    use Moderatable;
    use HasMediaTrait;
    use Visitable;

    protected $sortParameterName = 'sort';
    public $searchable           = ['name', 'email'];
    public $sortable             = ['user_id', 'name', 'created_at'];
    protected $fillable          = [
        'user_id',
        'category_id',
        'currency_id',
        'name',
        'description',
        'supply_ability',
        'fob_port',
        'payment_terms',
        'minimum_order',
        'price',
        'description_en',
        'description_id',
        'description_zh',
        'publish',
        'active',
    ];

    protected $allowTags = '<br><br/><b><i><u><p><strong><ul><ol><li><table><tr><td><hr>';

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->fit(Manipulations::FIT_FILL, 200, 200)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(500)
            ->height(500)
            ->fit(Manipulations::FIT_FILL, 500, 500)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->width(800)
            ->nonQueued();
    }

    public function owner()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function category()
    {
        return $this->hasOne('App\ProductCategory', 'id', 'category_id');
    }

    public function currency()
    {
        return $this->hasOne('App\Currency', 'id', 'currency_id');
    }

    public function pageviews()
    {
        return $this->hasMany('App\ProductPostVisit', 'product_id', 'id');
    }

    public function setDescriptionEnAttribute($value)
    {
        $this->attributes['description_en'] = strip_tags($value, $this->allowTags);
    }

    public function setDescriptionIdAttribute($value)
    {
        $this->attributes['description_id'] = strip_tags($value, $this->allowTags);
    }

    public function setDescriptionZhAttribute($value)
    {
        $this->attributes['description_zh'] = strip_tags($value, $this->allowTags);
    }

    public function scopePopularYear($query)
    {
        return $this->popularLast($query, 365);
    }

    public function visitsYear()
    {
        return $this->visitsLast(365);
    }

    public function scopeHasActivePackage($query)
    {
        return $query->published()->whereHas('owner.subscriptions', function ($q) {
            return $q->whereIn('plan_id', [1, 2, 4])
                ->where('ends_at', '>', now());
        })->hasBalance();
    }

    public function scopePublished($query)
    {
        return $query->where('publish', true);
    }

    public function scopeHasBalance($query)
    {
        return $query->orWhereHas('owner', function ($q) {
            $q->where('balance', '>', 1999)
                ->whereHas('subscriptions', function ($q) {
                    return $q->where('plan_id', 3);
                });
        });
    }
}
