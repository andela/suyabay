<?php

namespace Suyabay;

use Suyabay\User;
use Suyabay\Episode;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user_id',
        'episode_id',
        'comments'                    
    ];

    /**
     * Comment User relationship
     */
    public function user()
    {
    	return $this->belongsTo('Suyabay\User');
    }

    /**
     * Comment Episode relationship
     */
    public function episode()
    {
        return $this->belongsTo('Suyabay\Episode');
    }
}
