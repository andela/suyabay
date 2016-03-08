<?php

use Suyabay\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $this->login();

        $this->visit('dashboard/episode/create')
             ->type('test', 'title')
             ->type('Brief description', 'description')
             ->attach('/audio/BlueDucks_FourFlossFiveSix.mp3', 'podcast')
             ->press('create')
             ->assertEquals(0, count(Suyabay\Episode::where('episode_name', 'teststh')->get()));
    }

    /**
     * Test to verify that no new recorc is saved in the database if
     * the podcast file is less than 10MB
     */
    public function testValidationWorksForFilesExceeding10MB()
    {
        $this->login();

        $this->visit('dashboard/episode/create')
             ->type('test', 'title')
             ->type('Brief description', 'description')
             ->attach('/audio/Haiti.mp3', 'podcast')
             ->press('create')
             ->assertEquals(0, count(Suyabay\Episode::where('episode_name', 'teststh')->get()));
    }
}
