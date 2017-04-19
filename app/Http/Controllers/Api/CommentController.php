<?php

namespace Suyabay\Http\Controllers\Api;

use Auth;
use Suyabay\User;
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
use Suyabay\Http\Transformers\UserTransformer;
use Suyabay\Http\Transformers\CommentTransformer;
use Suyabay\Http\Transformers\EpisodeTransformer;
use Suyabay\Http\Transformers\UserCommentTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

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
     * @param $episodeTransformer
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
            return $this->displayComments($episode, $episodeTransformer);
        }

        return $this->displayCommentsByDate($episode, $request, $commentTransformer);
    }

    /**
     * This method displays the result of the comment
     *
     * @param $episode
     * @param $episodeTransformer
     *
     * @return json $response
     */
    public function displayComments($episode, $episodeTransformer)
    {
        $resource = new Item($episode, $episodeTransformer);
        $data     = $this->fractal->createData($resource)->toArray();

        return response()->json($data, 200);
    }

    /**
     * This method displays the result of the comment
     *
     * @param $episode
     * @param $request
     * @param $commentTransformer
     *
     * @return json $response
     */
    public function displayCommentsByDate($episode, $request, $commentTransformer)
    {
        $fromDate = $request->query('fromDate');
        $toDate   = $request->query('toDate');
        $limit    = $request->query('limit');

        $paginator = Comment::where('episode_id', $episode->id)
           ->orderBy('created_at', 'desc')
           ->whereBetween('created_at', [$fromDate, $toDate])
           ->take($limit)
           ->paginate($limit);

        $paginator = $paginator->appends(['fromDate' => $fromDate, 'toDate' => $toDate]);

        $comments = $paginator->getCollection();
        $resource = new Collection($comments, $commentTransformer);

        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        $data     = $this->fractal->createData($resource)->toArray();

        return response()->json($data, 200);
    }

    /**
     * This method retrieves the name and email of the episode comment
     *
     * @param $name
     * @param $id
     * @param $userTransformer
     *
     * @return json $response
     */
    public function getEpisodeCommenter($name, $id, UserTransformer $userTransformer)
    {
        $episode = $this->episodeRepository
            ->findEpisodeWhere('episode_name', strtolower(urldecode($name)))
            ->first();

        if (is_null($episode)) {
            return response()->json(['message' => 'Episode does not exist'], 404);
        }

        return $this->displayCommenterData($id, $episode, $userTransformer);
    }

    /**
     * This method retrieves all the name and email of the episode comment
     *
     * @param $episode
     * @param $id
     * @param $userTransformer
     *
     * @return json $response
     */
    public function displayCommenterData($id, $episode, $userTransformer)
    {
        $comment = $episode->comment()->where('id', $id)->first();

        if (is_null($comment)) {
            return response()->json(['message' => 'Comment not available for this episode, try another id'], 404);
        }

        $user     = $comment->user()->first();
        $resource = new Item($user, $userTransformer);
        $data     = $this->fractal->createData($resource)->toArray();

        return response()->json($data, 200);
    }

    /**
     * This method retrieves all the comments made by a particular user
     *
     * @param $username
     * @param $request
     * @param $userTransformer
     * @param $commentTransformer
     *
     * @return json $response
     */
    public function getUserComments($username, Request $request, UserCommentTransformer $userCommentTransformer, CommentTransformer $commentTransformer)
    {
        $user = User::where('username', $username)->first();

        if (is_null($user)) {
            return response()->json(['message' => 'This user does not exist'], 404);
        }

        if (! is_null($user->comments) && $user->comments->count() == 0) {
            return response()->json(['message' => 'Comment not available for this user'], 404);
        }

        if ($request->query->count() == 0) {
            return $this->displayUserComments($user, $userCommentTransformer);
        }

        return $this->displayUserCommentsByDate($user, $request, $commentTransformer);
    }

    /**
     * This method displays the result of the user comments
     *
     * @param $comment
     * @param $userCommentTransformer
     *
     * @return json $response
     */
    public function displayUserComments($user, $userCommentTransformer)
    {
        $resource = new Item($user, $userCommentTransformer);
        $data     = $this->fractal->createData($resource)->toArray();

        return response()->json($data, 200);
    }

    /**
     * This method displays the result of the comment
     *
     * @param $comment
     * @param $commentTransformer
     *
     * @return json $response
     */
    public function displayUserCommentsByDate($user, $request, $commentTransformer)
    {
        $fromDate = $request->query('fromDate');
        $toDate   = $request->query('toDate');
        $limit    = $request->query('limit');

        $paginator = Comment::where('user_id', $user->id)
           ->orderBy('created_at', 'desc')
           ->whereBetween('created_at', [$fromDate, $toDate])
           ->take($limit)
           ->paginate($limit);

        $paginator = $paginator->appends(['fromDate' => $fromDate, 'toDate' => $toDate]);

        $comments = $paginator->getCollection();
        $resource = new Collection($comments, $commentTransformer);

        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        
        $data     = $this->fractal->createData($resource)->toArray();

        return response()->json($data, 200);
    }
}
