<?php

namespace Suyabay\Http\Controllers;

use Suyabay\Http\Repository\LikeRepository;
use Suyabay\Http\Repository\EpisodeRepository;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
		$this->likeRepository 		= new LikeRepository;
		$this->episodeRepository 	= new EpisodeRepository;
	}
}
