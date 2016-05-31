<?php

namespace Suyabay\Http\Transformers;

use Suyabay\User;
use Suyabay\Comment;
use League\Fractal;
use Suyabay\Http\Repository\UserRepository;

class CommentTransformer extends Fractal\TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'comment_id'         => (int) $comment->id,
            'created_by'         => $comment->user_id,
            'episode_id'         => $comment->episode_id,
            'comments'           => $comment->comments,
            'date_created'       => $comment->created_at,
            'date_modified'      => $comment->updated_at
        ];
    }
}
