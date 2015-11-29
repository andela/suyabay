<?php

namespace Suyabay\Http\Controllers;

use Suyabay\Comment;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\Controller;

class CommentController extends Controller
{
    
	protected function create(array $data)
    {
        Comment::create([
            'comments' 		=> $data['comment'],
            'user_id' 		=> 1,
            'episode_id' 	=> 1
        ]);
	}

	public function postComment (Request $request)
	{
		$this->create($request->all());
		return redirect('/');
	}

}
