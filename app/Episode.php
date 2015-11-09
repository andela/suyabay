<?php

namespace Suyabay;

use Suyabay\Channel;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = [
                            'created_at',
                            'episode_name',
                            'episode_description',
                            'view_count',
                            'image',
                            'audio_mp3',
                            'channel_id'
                            ];

    public function channel()
    {
        return $this->belongsTo('Suyabay\Channel');
    }

}
