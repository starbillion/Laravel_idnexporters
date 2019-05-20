<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanRequest extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function plan()
    {
        return $this->hasOne('App\Plan', 'id', 'plan_id');
    }

    public function coupon()
    {
        return $this->hasOne('App\Coupon', 'id', 'coupon_id');
    }
}
