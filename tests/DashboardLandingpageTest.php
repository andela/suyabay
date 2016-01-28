<?php

use Suyabay\User;
use Suyabay\Episode;
use Suyabay\Channel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardLandingpageTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    /**
     * Test that an episode is created.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->createUser(1);

        $this->visit('/dashboard')->assertResponseOk();
    }

    /**
     * [testAuthorizedUserCanSeeAllEpisodes description]
     * @return [type] [description]
     */
    public function testAuthorizedUserCanSeeAllEpisodes()
    {
        $this->createUser(3);

        $this->visit('/dashboard/episodes');

        $this->assertResponseOk();
    }

}