<?php 
namespace Suyabay\Http\Transformers;

use Suyabay\Channel;
use League\Fractal;
use Suyabay\Http\Repository\UserRepository;

class ChannelTransformer extends Fractal\TransformerAbstract
{
    public function transform(Channel $channel)
    {
        $user = UserRepository::findUser($channel->user_id)->first();

        return [
        'channel_id'         => (int) $channel->id,
        'channel_name'       => $channel->channel_name,
        'channel_note'       => $channel->channel_description,
        'date_created'       => $channel->created_at,
        'date_modified'      => $channel->updated_at,
        'created_by'         => $user->username
        ];
    }
}
