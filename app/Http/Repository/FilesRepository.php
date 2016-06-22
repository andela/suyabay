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
     * Upload audio file to AWS
     * @param $filename
     * @return
     */
    public function audioToAWS($podcast)
    {
        // $podcastFileName = time() . '.' . $podcast->getClientOriginalExtension();
        // $s3 = Storage::disk('s3');
        // $filePath = $podcastFileName;
        // $s3->put($filePath, fopen($podcast, 'r+'), 'public');
        // $toAWS = "https://s3-us-west-2.amazonaws.com/suyabay/{$filePath}";

        // return $toAWS;
        // 
    }

    public function uploadToAws($filename, $file)
    {
        $s3 = Storage::disk('s3');
        $filename = $s3->put($filename, file_get_contents($file->getRealPath()), 'public');

        return "https://s3-us-west-2.amazonaws.com/suyabay/{$filename}";
    }
}
