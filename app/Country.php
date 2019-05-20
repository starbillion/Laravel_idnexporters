<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function continent()
    {
        return $this->hasOne('App\Continent', 'id', 'continent_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'country_id');
    }
}
