<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchTest extends TestCase
{
    use Suyabay\Tests\CreateData;
    use DatabaseMigrations;
    /**
     * Anyone can search episodes by name
     * Enter the episode name then hit enter.
     */
    public function testHome()
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
}
