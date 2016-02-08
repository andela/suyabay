<?php

namespace Suyabay\Http\Controllers;

use Suyabay\Comment;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\Controller;
use Auth;

class CommentController extends Controller
{

    /**
    * Add comment to database
    */
    protected function create(array $data)
    {
        Comment::create([
            'comments'      => $data['comment'],
            'user_id'       => $data['user_id'],
            'episode_id'    => $data['episode_id']
        ]);
    }

    /**
    * Process comment creation
    */
    public function postComment(Request $request)
    {
        $this->create($request->all());

        return $response =
            [
                'message' => 'Comment created Successfully',
                'status_code' => 200
            ];
    }

    /**
     * deleteComment Delete a comment that belongs to the logged in user
     * @param  [boolean] $commentId [true or false]
     * @return [boolean]            [true or false]
     */
    public function deleteComment($commentId)
    {
        $deleteComment = Comment::where('id', $commentId)
                                ->where('user_id', Auth::user()->id)
                                ->delete();

        return $deleteComment;
    }

    public function editComment(Request $request, $id)
    {
        return Comment::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->update([
                    'comments' => $request->input('comment')
                ]);
    }
}
