<?php

namespace Suyabay\Http\Transformers;

use League\Fractal;
use Suyabay\User;
use Suyabay\Http\Repository\UserRepository;

class UserCommentTransformer extends Fractal\TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'comment'
    ];

    public function transform(User $user)
    {
        return [
        'username'       => $user->username,
        'email'          => $user->email
        ];
    }

    /**
     * Include comment
     *
     * @return League\Fractal\ItemResource
     */
    public function includeComment(User $user)
    {
        $comments = $user->comments;

        return $this->collection($comments, new CommentTransformer);
    }
}
