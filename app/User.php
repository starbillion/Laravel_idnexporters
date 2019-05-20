<?php

namespace App;

use App\Language;
use Spatie\MediaLibrary\Media;
use Spatie\Image\Manipulations;
use Hootlex\Moderation\Moderatable;
use Jedrzej\Pimpable\PimpableTrait;
use Cog\Laravel\Ban\Traits\Bannable;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Gerardojbaez\LaraPlans\Traits\PlanSubscriber;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Jrean\UserVerification\Traits\UserVerification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Gerardojbaez\LaraPlans\Contracts\PlanSubscriberInterface;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class User extends Authenticatable implements BannableContract, PlanSubscriberInterface, HasMediaConversions
{
    use Moderatable;
    use PlanSubscriber;
    use LaratrustUserTrait;
    use Notifiable;
    use PimpableTrait;
    use SoftDeletes;
    use Bannable;
    use HasMediaTrait;
    use UserVerification;
    use Messagable;

    protected $sortParameterName = 'sort';
    public $searchable           = ['company', 'name', 'email'];
    public $sortable             = ['company', 'created_at'];
    protected $fillable          = [
        'salutation',
        'name',
        'email',
        'password',
        'company',
        'business_types',
        'established',
        'city',
        'postal',
        'country_id',
        'mobile',
        'phone_1',
        'phone_2',
        'fax',
        'categories',
        'company_email',
        'website',
        'hide_contact',
        'languages',
        'address',
        'description',
        'additional_notes',
        'main_exports',
        'main_imports',
        'export_destinations',
        'current_markets',
        'annual_revenue',
        'product_interests',
        'factory_address',
        'certifications',
        'video_1',
        'video_2',
        'video_3',
        'subscribe',
        'halal',
        'verified_member',
        'verified',
    ];
    protected $hidden = ['password', 'remember_token'];
    protected $casts  = [
        'categories'     => 'array',
        'business_types' => 'array',
        'languages'      => 'array',
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
            ->performOnCollections('logo')
            ->nonQueued();
    }

    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = $password ? bcrypt($password) : null;
        }
    }

    public function country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }

    public function language()
    {
        return $this->hasOne('App\Language', 'id', 'language_id');
    }

    public function products()
    {
        return $this->hasMany('App\ProductPost', 'user_id', 'id');
    }

    public function scopeHasActivePackage($query)
    {
        return $query->whereHas('subscriptions', function ($q) {
            return $q->where('ends_at', '>', now());
        });
    }
}
