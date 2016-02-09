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

        return [
                'message' => 'Comment created Successfully',
                'status_code' => 200
            ];
    }

    /**
     * deleteComment Delete a comment that belongs to the logged in user
     * @param  [boolean] $commentId [true or false]
     * @return [boolean]            [true or false]
     */
    public function deleteComment(Request $request, $commentId)
    {
        $request->session()->flash('show_comments', true);

        $deleteComment = Comment::where('id', $commentId)
                                ->where('user_id', Auth::user()->id)
                                ->delete();

        return $deleteComment;
    }

    /**
     * editComment, Allow an authenticated user to update the contents of a comment.
     *
     * @param  Request $request HTTP request handler
     * @param  integer  $id      Comment ID
     *
     * @return boolean           Return true or false depending on whether the comment
     * was updated
     */
    public function editComment(Request $request, $id)
    {
        $request->session()->flash('show_comments', true);

        return Comment::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->update([
                    'comments' => $request->input('comment')
                ]);
    }
}
