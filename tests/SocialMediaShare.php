<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SocialMediaShare extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

     public function testFacebookShare()
     {
     	factory('Suyabay\Channel')->create();
     	factory('Suyabay\Episode', 3)->create();

         $this->visit('/')
         	->click('fb-share')
            ->seePageIs('SUYABAY');
     }

    public function testTwitterShare()
    {
    	factory('Suyabay\Channel')->create();
    	factory('Suyabay\Episode', 3)->create();

        $this->visit('/')
        	->click('twtr-share')
        	->seePageIs('SUYABAY');
    }
}
