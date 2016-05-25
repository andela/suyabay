<?php

namespace Suyabay\Http\Controllers\Api;

use DB;
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
     *
     * @return json $response
     */
    public function getAllComments($name, Request $request, commentTransformer $commentTransformer)
    {
        $fromDate = $request->query('fromDate');
        $toDate   = $request->query('toDate');
        $limit    = $request->query('limit') ? : 10;

        $episodes = $this->episodeRepository
            ->findEpisodeWhere('episode_name', strtolower(urldecode($name)))
            ->get()
            ->first();

        if (is_null($episodes)) {
            return response()->json(['message' => 'Episode does not exist'], 404);
        }

        $comment = Comment::where('episode_id', $episodes->id)
            ->orderBy('created_at', 'desc')
            ->whereBetween('created_at', [$fromDate, $toDate]);
    
        if (is_null($comment->first())) {
            return response()->json(['message' => 'Comment not available for this episode'], 404);
        }

        $comments = $comment->take($limit)->get();
        $resource = new Collection($comments, $commentTransformer);
        
        $data = $this->fractal->createData($resource)->toArray();

        return response()->json($data, 200);
    }
}
