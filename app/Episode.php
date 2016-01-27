<?php

namespace Suyabay;

use Suyabay\Like;
use Suyabay\Channel;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = ['created_at', 'episode_name', 'episode_description', 'view_count', 'image', 'audio_mp3', 'channel_id', 'status', 'flag', 'likes'];

    /**
     * @return
     */
    public function channel()
    {
        return $this->belongsTo('Suyabay\Channel');
    }

    /**
     * 
     * @return
     */
    public function comment()
    {
        return $this->hasMany('Suyabay\Comment');
    }

    /**
     * [like description]
     * @return [type] [description]
     */
    public function like()
    {
        return $this->hasMany('Suyabay\Like');
    }

}
