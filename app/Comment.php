<?php

namespace Suyabay;

use Suyabay\Episode;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user_id',
        'episode_id',
        'comments'                    
    ];

    public function episode()
    {
        return $this->belongsTo('Suyabay\Episode');
    }
}
