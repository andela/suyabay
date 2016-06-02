<?php

namespace Suyabay\Http\Controllers\Api;

use Validator;
use Suyabay\User;
use Suyabay\Favourite;
use Suyabay\Http\Requests;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use Illuminate\Mail\Mailer as Mail;
use Illuminate\Support\Facades\Response;
use Suyabay\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;
use Suyabay\Http\Transformers\UserLikedEpisodeTransformer;

class UserEpisodesLikeController extends Controller
{
    protected $fractal;

    public function __construct(Manager $fractal, Mail $mail)
    {
        $this->fractal = $fractal;
    }

    /**
     * This method get all the episode podcast liked by a user.
     *
     * @param $username
     *
     * @return like
     */
    public function getUserLikedEpisodes($username, UserLikedEpisodeTransformer $userLikedEpisodeTransformer)
    {
        $user = User::where('username', urldecode($username))->first();

        if (is_null($user)) {
            return Response::json(['message' => 'User not found!'], 404);

        }

        $likes = $user->likes;

        if (count($likes) > 0) {
            return Response::json(
                $this->createUserLikedEpisodeResponse($likes, $userLikedEpisodeTransformer),
                200
            );
        }

        return Response::json(['message' => 'User has 0 episode like(s)!'], 404);
    }

    /**
     * This method loads all the episodes liked by a user,
     * and returns a Like model which has a one to Many relationship with 
     * the user Model. So in other to get all episode likes we interate over
     * the likes and get all the episodes under it.
     *
     * @param $user
     *
     * @return Like
     */
    public function loadUserLikesWithEpisode($likes)
    {
        foreach ($likes as $like) {
            $like->episode;
        }

        return $likes;
    }

    /**
     * This method creates user episode likes data and return it back
     * to the response body.
     *
     * @param $likes
     * @param $userLikedEpisodeTransformer
     *
     * @return $data
     */
    public function createUserLikedEpisodeResponse($likes, $userLikedEpisodeTransformer)
    {
        $resource = new Collection(
            $this->loadUserLikesWithEpisode($likes),
            $userLikedEpisodeTransformer
        );
        return $data = $this->fractal->createData($resource)->toArray();
    }
}
