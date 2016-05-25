<?php

namespace Suyabay\Http\Transformers;

use Suyabay\Like;
use League\Fractal;

class UserLikedEpisodeTransformer extends Fractal\TransformerAbstract
{
    public function transform(Like $like)
    {
        return [
            'name'               => $like->episode->episode_name,
            'brief_description'  => $like->episode->episode_description,
            'views'              => $like->episode->view_count,
            'likes'              => $like->episode->likes,
            'picture_url'        => $like->episode->image,
            'audio_url'          => $like->episode->audio_mp3,
            'date_created'       => $like->episode->created_at,
            'date_modified'      => $like->episode->updated_at,
            'created_by'         => $like->user->username,
        ];
    }
}
