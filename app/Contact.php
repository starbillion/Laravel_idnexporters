<?php

namespace App;

use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use Notifiable;

    use PimpableTrait;

    protected $sortParameterName = 'sort';
    public $searchable           = ['name', 'email', 'mobile'];
    public $sortable             = ['name', 'email', 'mobile', 'created_at'];
    protected $fillable          = [
        'name',
        'email',
        'mobile',
        'body',
    ];
}
