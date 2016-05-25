<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserEpisodeLikesTest extends TestCase 
{
    public function testThatUsernameSuppliedIsCorrect()
    {
        $user = factory('Suyabay\User')->create();
        $episode = factory('Suyabay\Episode')->create();
        $likes = factory('Suyabay\Like')->create([
            'user_id'    => $user->id ,
            'episode_id' => $episode->id,
        ]);

        $response = 
        $this->actingAs($user)
        ->call('GET', '/api/v1/users/Laztopaz/favourites');

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'User not found!');
        $this->assertEquals($response->status(), 404);
    }
    
}