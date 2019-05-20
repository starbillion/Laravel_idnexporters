<?php

namespace App;

use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use PimpableTrait;
    use SoftDeletes;

    protected $sortParameterName = 'sort';
    public $searchable           = ['code'];
    public $sortable             = ['code', 'created_at'];
    protected $fillable          = [
        'code',
        'nominal',
        'note',
    ];
}
