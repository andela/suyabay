<?php

namespace Suyabay\Http\Controllers\Api;

use Suyabay\Comment;
use Suyabay\Episode;
use Suyabay\Http\Requests;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Suyabay\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Suyabay\Http\Repository\EpisodeRepository;
use Suyabay\Http\Transformers\CommentTransformer;
use Suyabay\Http\Transformers\EpisodeTransformer;

class CommentController extends Controller
{
    protected $response;
    protected $fractal;

    /**
     * Fractal is injected here inside a constructor to initilize
     * it.
     *
    */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * This method retrieves all the comments in a particular episode
     *
     * @param $name
     *
     * @return json $response
     */
    public function getAllComments($name, commentTransformer $commentTransformer)
    {
        $episodes = Episode::where('episode_name', '=', strtolower(urldecode($name)))
	        ->get()
	        ->first();

        if (is_null($episodes)) {
            return Response::json(['message' => 'Episode does not exist'], 404);
	    }

        $comment = Comment::where('episode_id', '=', $episodes->id);

        if (is_null($comment->first())) {
            return Response::json(['message' => 'Comment not available for this episode'], 404);
        }

        $comments = $comment->first()->episode->comment;
        $resource = new Collection($comments, $commentTransformer);

        $data = $this->fractal->createData($resource)->toArray();

        if (count($data['data']) > 0) {
            return Response::json($data, 200);
        }
    }
}
