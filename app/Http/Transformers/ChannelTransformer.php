<?php
namespace Suyabay\Http\Transformers;

use Suyabay\Channel;
use League\Fractal;
use Suyabay\Http\Repository\UserRepository;

class ChannelTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'episode',
    ];

    public function transform(Channel $channel)
    {
        return [
        'channel_id'         => (int) $channel->id,
        'channel_name'       => $channel->channel_name,
        'channel_note'       => $channel->channel_description,
        'date_created'       => $channel->created_at,
        'date_modified'      => $channel->updated_at,
        'created_by'         => $channel->user_id,
        ];
    }

    /**
     * Include Episode
     *
     * @param Episode $episode
     * @return \League\Fractal\Resource\Collection
     */
    public function includeEpisode(Channel $channel)
    {
        $episode = $channel->episode;

        return $this->collection($episode, new EpisodeTransformer);
    }
}
