<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EpisodeSizeTest extends TestCase
{

    use Suyabay\Tests\CreateData;

    /**
     * Test to verify that no new record is saved in the database if
     * an attachment is missing in the podcast field
     */
    public function testValidationWorksWhenPodcastFieldIsEmpty()
    {
        $this->login();

        $this->visit('dashboard/episode/create')
             ->type('teststh', 'title')
             ->type('Brief description', 'description')
             ->press('create')
             ->assertEquals(0, count(Suyabay\Episode::where('episode_name', 'teststh')->get()));
    }

    /**
     * Test to verify that no new record is saved in the database if
     * the podcast file is less than 1 MB
     */
    public function testValidationWorksForUploadedFilesLessThan1MB()
    {
        $this->WithoutMiddleware();

        $uploadedFile = Mockery::mock(
            UploadedFile::class,
            [
                'getClientOriginalName'      => 'audio',
                'getClientOriginalExtension' => 'mp3',
                'getPath' => 'public/audio.mp3',
                'getClientSize' => 53674,
                'test' => true,
                'size' => 447,
            ]
        );

        Storage::shouldReceive('disk')->with('s3')->andReturnSelf();
        Storage::shouldReceive('put')->with('public/audio.mp3')->andReturn(true);

        $user = factory('Suyabay\User')->create();
        $channel = factory('Suyabay\Channel')->create();
        // make a request
        $uploadedFile->shouldReceive('audioToAWS')
                     ->once()
                     ->with('public/nowaudio.mp3');

        // var_dump($uploadedFile);
        // die();

         $response = $this->actingAs($user)
            ->call(
                'POST',
                '/dashboard/episode/create',
                [
                    'title' => 'Exceed',
                    'description' => 'Brief description',
                    'channel' => $channel['id'],
                    'podcast' => $uploadedFile
                ]
            );
            echo $response;
    }

    /**
     * Test to verify that no new record is saved in the database if
     * the podcast file is less than 10MB
     */
    public function testValidationWorksForFilesExceeding10MB()
    {
        $this->WithoutMiddleware();

        $uploadedFile = Mockery::mock(
            'Illuminate\Filesystem\Filesystem',
            [
                'getClientOriginalName'      => 'audio.mp3',
                'getClientOriginalExtension' => 'mp3',
                'getClientOriginalSize' => '73M',
            ]
        );
        dd($uploadedFile);
        $user = factory('Suyabay\User')->create();
        $channel = factory('Suyabay\Channel')->create();
        // make a request
        $response = $this->actingAs($user)
             ->call(
                 'POST',
                 '/dashboard/episode/create',
                 [
                    'title'          => 'Exceed',
                    'description'   => 'Brief description',
                    'channel'            => $channel['id'],
                    'podcast'             => $uploadedFile,
                 ]
             );
        echo $response;
    }

    /**
     * Test to verify that a new record is saved in the database if a file
     * that meets the size limit is uploaded
     */
    public function testFileUploadWithinLimit()
    {
        $this->login();

        $this->visit('dashboard/episode/create')
             ->type('Kanye', 'title')
             ->type('With Love', 'description')
             ->attach(storage_path('audio/love.m4a'), 'podcast')
             ->press('create')
             ->assertEquals(1, count(Suyabay\Episode::where('episode_name', 'Kanye')->get()));
    }

    public function testCorrectMimeTypeIsUploaded()
    {
        $this->login();

        $this->visit('dashboard/episode/create')
             ->type('Kanye', 'title')
             ->type('With Love', 'description')
             ->attach(storage_path('audio/image.jpg'), 'podcast')
             ->press('create')
             ->assertEquals(0, count(Suyabay\Episode::where('episode_name', 'Kanye')->get()));
    }
}

// function time()
// {
//     return "now";
// }
