<?php

namespace Suyabay\Http\Controllers\Api;

use Carbon\Carbon;
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
    protected $fractal;
    protected $episodeRepository;

    /**
     * Fractal is injected here inside the constructor to initialize
     * the Transformer. The episodeRepository is also called here to
     * initialize it
     */
    public function __construct(Manager $fractal, EpisodeRepository $episodeRepository)
    {
        $this->fractal           = $fractal;
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * This method retrieves all the comments in a particular episode
     *
     * @param $name
     * @param $request
     * @param $commentTransformer
     *
     * @return json $response
     */
    public function getEpisodeComments($name, Request $request, EpisodeTransformer $episodeTransformer, CommentTransformer $commentTransformer)
    {
        $episode = $this->episodeRepository
            ->findEpisodeWhere('episode_name', strtolower(urldecode($name)))
            ->first();

        if (is_null($episode)) {
            return response()->json(['message' => 'Episode does not exist'], 404);
        }

        if (! is_null($episode->comment) && $episode->comment->count() == 0) {
            return response()->json(['message' => 'Comment not available for this episode'], 404);
        }

        if ($request->query->count() == 0) {
            return $this->displayAllComments($episode, $episodeTransformer);
        }

        return $this->displayCommentsByDate($episode, $request, $commentTransformer);
    }

    /**
     * This method displays the result of the comment
     *
     * @param $comment
     * @param $limit
     * @param $commentTransformer
     *
     * @return json $response
     */
    public function displayComments($episode, $episodeTransformer)
    {
        $episode  = $episode->get();
        $resource = new Collection($episode, $episodeTransformer);

        $data     = $this->fractal->createData($resource)->toArray();

        return response()->json($data, 200);
    }

    /**
     * This method displays the result of the comment
     *
     * @param $comment
     * @param $limit
     * @param $commentTransformer
     *
     * @return json $response
     */
    public function displayCommentsByDate($episode, $request, $commentTransformer)
    {
        $fromDate = $request->query('fromDate');
        $toDate   = $request->query('toDate');
        $limit    = $request->query('limit');

        $comments = Comment::where('episode_id', $episode->id)
           ->orderBy('created_at', 'desc')
           ->whereBetween('created_at', [$fromDate, $toDate])
           ->take($limit)
           ->get();

        $resource = new Collection($comments, $commentTransformer);

        $data     = $this->fractal->createData($resource)->toArray();

        return response()->json($data, 200);
    }
}
