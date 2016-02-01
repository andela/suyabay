<?php

namespace Suyabay;

use Suyabay\Episode;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'episode_id', 'created_at', 'updated_at'];

    public function episode()
    {
        return $this->belongsTo('Suyabay\Episode');
    }

    public function user()
    {
        return $this->belongsTo('Suyabay\User');
    }
}
