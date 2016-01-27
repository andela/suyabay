<?php

namespace Suyabay\Http\Repository;

use Storage;
use Session;
use Cloudder;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Aws\S3\Exception\S3Exception as S3;
use Aws\Exception\AwsException as AWS;
use Suyabay\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Filesystem;

class FilesRepository
{
    public function __construct()
    {
        $this->cloudder = new Cloudder;
    }

    /**
     * Upload file to amazon S3
     * @param  [type] $podcast [description]
     * @return [type]          [description]
     */
    public function toAmazon($podcast)
    {
        $fileName = time() . '.' . $podcast->getClientOriginalExtension();
        $s3 = Storage::disk('s3');

        $s3->put($fileName, fopen($podcast, 'r+'));

        return $s3->getDriver()->getAdapter()->getClient()->getObjectUrl('suyabay', $fileName);
    }

    /**
     * Upload file to cloudinary
     * @param  [type] $cover [description]
     * @return [type]        [description]
     */
    public function imageToCloudinary($cover)
    {
        $this->cloudder::upload($cover, null, ["width" => 500, "height" => 375, "crop" => "scale"]);
        
        return $this->cloudder::getResult()['url'];
    }

    /**
     * Upload audio file to cloudinary
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    public function videoToCloudinary($podcast)
    {
        $this->cloudder::uploadVideo($podcast, null);

        return $this->cloudder::getResult()['url'];
    }  
}
