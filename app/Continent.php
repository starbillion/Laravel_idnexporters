<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    public function countries()
    {
        return $this->hasMany('App\Country', 'continent_id', 'id');
    }
}
