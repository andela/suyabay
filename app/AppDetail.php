<?php

namespace Suyabay;

use Illuminate\Database\Eloquent\Model;

class AppDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'homepage_url',
        'description',
        'api_token'
    ];

    /**
     * .
     *
     * 
     */
    public function user()
    {
        return $this->belongsTo('Suyabay\User');
    }
}
