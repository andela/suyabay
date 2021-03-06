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
     * Each episode has many comments
     *
     * @return object
     */
    public function comment()
    {
        return $this->hasMany('Suyabay\Comment');
    }

    /**
     * Each episode has many likes
     *
     * @return object
     */
    public function like()
    {
        return $this->hasMany('Suyabay\Like');
    }

    /**
     * Increment the number of views of the episode by 1.
     *
     * @return object
     */
    public function incrementViews()
    {
        $this->views++;
        $this->save();
        
        return $this;
    }
}
