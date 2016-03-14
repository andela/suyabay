<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchTest extends TestCase
{
    use Suyabay\Tests\CreateData;
    /**
     * Anyone can search episodes by name
     * Enter the episode name then hit enter.
     */
    public function testSearchLink()
    {
        $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();

        $this->visit('/')
             ->see('suyabay')
             ->type('terms', 'query')
             ->press('search')
             ->seePageIs('/search?query=terms&search=');
    }

    /**
     * Test that when a user searches for an episode,it
     * returns all episodes that match the pattern.
     *
     * @return [type] [description]
     */
    public function testResults()
    {
        factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create();

        $this->call(
            'GET',
            '/search?query=' .$episode['episode_name'] . '&search='
        );
        $this->assertViewHasAll(['results', 'channels']);
        $this->see($episode['episode_name']);
    }
}
