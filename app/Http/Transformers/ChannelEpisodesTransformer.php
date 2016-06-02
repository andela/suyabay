<?php
namespace Suyabay\Http\Transformers;

use League\Fractal;
use Suyabay\Episode;

class ChannelEpisodesTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'comment',
        'channel',
        'user',
       
    ];

    public function transform(Episode $episode)
    {
        return [
            'id'                 => (int) $episode->id,
            'name'               => $episode->episode_name,
            'brief_description'  => $episode->episode_description,
            'views'              => $episode->view_count,
            'likes'              => $episode->likes,
            'picture_url'        => $episode->image,
            'audio_url'          => $episode->audio_mp3,
            'date_created'       => $episode->created_at,
            'date_modified'      => $episode->updated_at,
        ];
    }

    /**
     * Include Comment
     *
     * @param Episode $episode
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComment(Episode $episode)
    {
        $comment = $episode->comment;

        return $this->collection($comment, new EpisodeCommentsTransformer);
    }

    /**
     * Include Channel
     *
     * @param Episode $episode
     * @return \League\Fractal\Resource\Collection
     */
    public function includeChannel(Episode $episode)
    {
        $channel = $episode->channel;

        return $this->item($channel, new ChannelWithoutEpisodeTransformer);
    }

    /**
     * Include Channel
     *
     * @param Episode $episode
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUser(Episode $episode)
    {
        $user = $episode->channel->user;

        return $this->item($user, new UserTransformer);
    }
}
