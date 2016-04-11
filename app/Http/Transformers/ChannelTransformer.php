<?php 
namespace Suyabay\Http\Transformers;

use League\Fractal;
use Suyabay\Channel;

class ChannelTransformer extends Fractal\TransformerAbstract
{
    public function transform(Channel $channel)
    {
        return [
        'user_id'            => (int) $channel->id,
        'channel_name'       => $channel->channel_name,
        'channel_note'       => $channel->channel_description,
        'subscription_count' => $channel->subscription_count,
        'date_created'       => $channel->created_at,
        'date_modified'      => $channel->updated_at,
        'created_by'         => $channel->user_id
        ];
    }
}