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
        $userData = $this->getOauthID($provider);
        if(is_null($this->checkUserExist($userData, $provider)))
        {
            return $this->findByIDorCreate($userData, $provider);
        }
        $user = $this->findByIDorCreate($this->getOauthID($provider), $provider);

        Auth::login($user, true);

        return $this->userHasLoggedIn();
    }

    public function checkUserExist($value, $provider)
    {
        $columnName  = $provider.'ID';
        $user = User::where($columnName, $value->getId())->first();
        return $user;
    }
    /**
     * getOauthID Get the social account details
     *
     * @param  $provider
     * @return [object]
     */
    public function getOauthID($provider)
    {
        return Socialite::driver( $provider )->user();
    }

    /**
     * userHasLoggedIn Redirect to main page
     */
    public function userHasLoggedIn()
    {
        return redirect('/');
    }

    /**
     * findByIDorCreate check if user already exist
     *
     * @param  $userData
     * @param  $provider
     */
    public function findByIDorCreate($userData, $provider)
    {
        $columnName  = $provider.'ID';
        $user = User::where('email', $userData->getEmail())->orWhere($columnName, $userData->getId())->first();

        if( $user){
            User::where('id', $user->id)->update([$columnName => $userData->getId()]);
            return $user;
        }
        return $this->socialFunction($userData);
    }

    public function socialFunction($userData, $provider)
    {
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
        return view('app.pages.signup', ['email' => $userData->getEmail(), 'github' => $userData->getId(), 'facebook' => 0, 'twitter' => 0]);
    }

    public function insertFacebook($userData)
    {
        return view('app.pages.signup', ['email' => $userData->getEmail(), 'github' => 0, 'facebook' => $userData->getId(), 'twitter' => 0]);
    }

    public function insertTwitter($userData)
    {
        return view('app.pages.signup', ['email' => $userData->getEmail(), 'github' => 0, 'facebook' => 0, 'twitter' => $userData->getId()]);
    }
}
