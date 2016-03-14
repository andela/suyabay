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
     * Test that when a user searches for an episode by episode
     * name ,it returns all episodes that match the pattern.
     *
     * @return void
     */
    public function testSearchByEpisodeName()
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

    /**
     * Test that when a user searches for an episode with a episode
     *  description,it returns all episodes that match the description.
     *
     * @return void
     */
    public function testSearchByEpisodeDescription()
    {
        factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create();

        $this->call(
            'GET',
            '/search?query=' .$episode['episode_description'] . '&search='
        );
        $this->assertViewHasAll(['results', 'channels']);
        $this->see($episode['episode_description']);
    }

    /**
     * Assert that The text No results found is displayed when one enters search
     * terms which don't match any episode name or description
     *
     * @return void
     */
    public function testSearchForNonExistentEpisode()
    {
        factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create();

        $this->call(
            'GET',
            '/search?query=SwankyNonExistentEpisode&search='
        );
        $this->assertViewHasAll(['results', 'channels']);
        $this->dontSee($episode['episode_name']);
        $this->dontSee($episode['episode_description']);
        $this->see('No results found, sorry');
    }
}
