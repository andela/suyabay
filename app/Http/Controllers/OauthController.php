<?php

namespace Suyabay\Http\Controllers;

use Auth;
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

        $user = $this->findByIDorCreate($this->getOauthID($provider), $provider);

        Auth::login($user, true);

       return $this->userHasLoggedIn();
    }

    public function getOauthID($provider)
    {
        return Socialite::driver( $provider )->user();
    }

    public function userHasLoggedIn()
    {
        return redirect('/');
    }

    public function findByIDorCreate($userData, $provider)
    {
        $columnName  = $provider.'ID';
        $user = User::where('email', $userData->getEmail())->orWhere($columnName, $userData->getId())->first();

        if( $user || $user->$columnName == 0 ){
            User::where('id', $user->id)->update([$columnName => $userData->getId()]);
            return $user;
        }

        if($provider == "github"){
            return $this->insertGithub($userData);
        }
        elseif($provider == "facebook"){
            return $this->insertFacebook($userData);
        }
        elseif($provider == "twitter"){
            return $this->insertTwitter($userData);
        }
    }

    public function insertGithub($userData)
    {
        return User::firstOrCreate([
            'username' => $userData->getNickname(),
            'email' => $userData->getEmail(),
            'password' => 'password',
            'githubID' => $userData->getId(),
            'facebookID' => 0,
            'twitterID' => 0
        ]);
    }

    public function insertFacebook($userData)
    {
        $split = explode(" ", $userData->getName());

        return User::firstOrCreate([
            'username' => $split[0]."".$split[1],
            'email' => $userData->getEmail(),
            'password' => 'password',
            'githubID' => 0,
            'facebookID' => $userData->getId(),
            'twitterID' => 0
        ]);
    }

    public function insertTwitter($userData)
    {
        return User::firstOrCreate([
            'username' => $userData->getNickname(),
            'email' => $userData->getEmail(),
            'password' => 'password',
            'githubID' => 0,
            'facebookID' => 0,
            'twitterID' => $userData->getId()
        ]);
    }
}
