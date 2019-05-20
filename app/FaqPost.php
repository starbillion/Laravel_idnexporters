<?php

namespace App;

use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;

class FaqPost extends Model
{
    use PimpableTrait;

    protected $sortParameterName = 'sort';
    public $searchable           = ['question', 'answer'];
    public $sortable             = ['question', 'created_at'];
    protected $fillable          = [
        'question',
        'answer',
        'category_id',
    ];
}
