<?php

namespace Suyabay\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Suyabay\Http\Repository\ChannelRepository;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    	$this->channelRepository = new ChannelRepository();
    }
}
