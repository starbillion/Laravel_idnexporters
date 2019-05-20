<?php

namespace App;

use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use PimpableTrait;

    protected $sortParameterName = 'sort';
    public $searchable           = ['name'];
    public $sortable             = ['name', 'created_at'];
    protected $fillable          = [
        'name',
    ];

    public function posts()
    {
        return $this->hasMany('App\FaqPost', 'category_id', 'id');
    }
}
