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
        $user = User::where('username', urldecode($username))
        ->get()
        ->first();
        if (is_null($user)) {
            return Response::json(['message' => 'User not found!'], 404);

        }

        $likes = $user->likes()->get();

        if (count($likes) > 0) {
            $resource = new Collection(
                $this->formatUserEpisodeLikes($likes),
                $userLikedEpisodeTransformer
            );
            $data = $this->fractal->createData($resource)->toArray();

             return Response::json($data, 200);
        }

        return Response::json(['message' => 'User has 0 episode like(s)!'], 404);
    }

    /**
     * This method formats and return episodes liked by a user.
     *
     * @param $user
     *
     * @return Like
     */
    public function formatUserEpisodeLikes($likes)
    {
        foreach ($likes as $key => $value) {
            $value->episode;
        }

        return $likes;
    }
}