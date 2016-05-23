<?php
namespace Suyabay\Http\Transformers;

use Suyabay\Comment;
use League\Fractal;
use Suyabay\Http\Repository\UserRepository;

class commentTransformer extends Fractal\TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
        'comment_id'         => (int) $comment->id,
        'created_by'         => $channel->user_id,
        'episode'            => $comment->episode_id,
        'comments'            => $comment->comments,
        'date_created'       => $comment->created_at,
        'date_modified'      => $comment->updated_at
        ];
    }
}
