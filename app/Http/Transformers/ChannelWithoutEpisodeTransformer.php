<?php
namespace Suyabay\Http\Transformers;

use League\Fractal;
use Suyabay\Channel;

class ChannelWithoutEpisodeTransformer extends Fractal\TransformerAbstract
{
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
}