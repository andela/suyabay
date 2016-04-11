<?php

namespace Suyabay;

use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    	'name',
    	'homepage_url',
    	'description'
    ];
}
