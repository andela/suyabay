<?php
namespace Suyabay\Http\Transformers;

use League\Fractal;
use Suyabay\Episode;

class ChannelEpisodesTransformer extends Fractal\TransformerAbstract
{
    public function transform(Episode $episode)
    {
        return [
            'id'                 => (int) $episode->id,
            'channel_name'       => $episode->channel->channel_name,
            'name'               => $episode->episode_name,
            'brief_description'  => $episode->episode_description,
            'views'              => $episode->view_count,
            'likes'              => $episode->likes,
            'picture_url'        => $episode->image,
            'audio_url'          => $episode->audio_mp3,
            'date_created'       => $episode->created_at,
            'date_modified'      => $episode->updated_at,
            'created_by'         => $episode->channel->user->username,
        ];
    }
}