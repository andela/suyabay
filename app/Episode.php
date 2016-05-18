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
     * This method returns total number of comments.
     *
     * @param $query
     * @param $id
     *
     * @return $query
     */
    public function scopeEpisodeComments($query, $id)
    {
        return $query->where('episodes.id', '=', $id)
        ->join('comments', 'episodes.id', '=', 'comments.episode_id');
    }
}
