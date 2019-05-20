<?php

namespace App;

use Laratrust\LaratrustRole;
use Jedrzej\Pimpable\PimpableTrait;

class Role extends LaratrustRole
{
    use PimpableTrait;

    public $searchable  = ['name', 'display_name'];
    public $sortable    = ['name', 'created_at'];
    protected $fillable = [
        'name',
        'display_name',
    ];
}
