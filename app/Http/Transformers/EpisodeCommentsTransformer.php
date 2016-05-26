<?php
namespace Suyabay\Http\Transformers;

use League\Fractal;
use Suyabay\Comment;

class EpisodeCommentsTransformer extends Fractal\TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'comment_id' => (int) $comment->id,
            'comment'   => $comment->comments,
        ];
    }
}