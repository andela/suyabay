<?php

namespace Suyabay\Http\Transformers;

use Suyabay\Episode;
use League\Fractal;
use Suyabay\Http\Repository\ChannelRepository;

class EpisodeTransformer extends Fractal\TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'comment'
    ];

    public function transform(Episode $episode)
    {
        return [
            'episode_id'         => (int) $episode->id,
            'episode_name'       => $episode->episode_name,
            'episode_note'       => $episode->episode_description,
            'date_created'       => $episode->created_at,
            'date_modified'      => $episode->updated_at,
            'channel_id'         => $episode->channel_id,
            'likes'              => $episode->likes,
            'cover_image_url'    => $episode->image,
            'audio'              => $episode->audio_mp3,
        ];
    }

    /**
     * Include comment
     *
     * @return League\Fractal\ItemResource
     */
    public function includeComment(Episode $episode)
    {
        $comments = $episode->comment;

        return $this->collection($comments, new CommentTransformer);
    }
}
