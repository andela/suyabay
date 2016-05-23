<?php

namespace Suyabay\Http\Transformers;

use Suyabay\Episode;
use League\Fractal;
use Suyabay\Http\Repository\ChannelRepository;

class EpisodeTransformer extends Fractal\TransformerAbstract
{
    public function transform(Episode $episode)
    {
        return [
            'episode_id'         => (int) $episode->id,
            'episode_name'       => $episode->episode_name,
            'episode_note'       => $episode->episode_description,
            'date_created'       => $episode->created_at,
            'date_modified'      => $episode->updated_at,
            'channel'            => $episode->channel_id,
            'likes'              => $episode->likes,
            'cover_image_url'    => $episode->image,
            'audio'              => $episode->audio_mp3,
        ];
    }
}
