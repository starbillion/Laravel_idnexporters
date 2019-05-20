<?php

namespace App;

use Kalnoy\Nestedset\NodeTrait;
use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use NodeTrait;
    use PimpableTrait;

    protected $sortParameterName = 'sort';
    public $searchable           = ['name'];
    public $sortable             = ['name', 'created_at'];
    protected $fillable          = ['name'];

    public function posts()
    {
        return $this->hasMany('App\ProductPost', 'category_id', 'id');
    }
}
