<?php

namespace Suyabay\Http\Controllers;

use Socialite;
use Suyabay\User;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\Controller;

class OauthController extends Controller
{
    /**
     * Social ouath login/registration
     *
     * @param  Request $request  [description]
     * @param  [type]  $provider [description]
     */
    public function getSocialRedirect(Request $request, $provider )
    {
        if( !($request->has('code') || $request->has('oauth_token')))
        {
            return Socialite::driver( $provider )->redirect();
        }

        $user = $this->findByIDorCreate($this->getOauthID($provider));

        $this->auth->login($user, true);

       return $listener->userHasLoggedIn($user);
    }

    public function getOauthID($provider)
    {
        $s = Socialite::driver( $provider )->user();
        dd($s);
    }

    public function findByIDorCreate($userData)
    {
        $data = [
            'username' => $userData->getNickname(),
            'email' => $userData->getEmail(),
            'password' => 'password'
        ];

        dd($data);
    }
}
