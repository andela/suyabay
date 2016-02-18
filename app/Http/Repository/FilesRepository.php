<?php

namespace Suyabay\Http\Repository;

use Storage;
use Session;
use Cloudder;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Aws\Exception\AwsException as AWS;
use Aws\S3\Exception\S3Exception as S3;
use Suyabay\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Filesystem;

class FilesRepository
{
    /**
     * Upload audio file to cloudinary
     * @param $filename
     * @return
     */
    public function audioToCloudinary($podcast)
    {
        Cloudder::uploadVideo($podcast, null);

        return Cloudder::getResult()['url'];
    }
}
