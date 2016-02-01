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
     * @param  $request
     * @param  $provider
     *
     * @return  [object]
     */
    public function getSocialRedirect(Request $request, $provider )
    {
        if (!($request->has('code') || $request->has('oauth_token'))) {

            return Socialite::driver( $provider )->redirect();
        }

        $userData = $this->getOauth($provider);

        if (is_null($this->checkUserExist($userData, $provider))) {

            return $this->socialFunction($userData, $provider);
        }

        $user = $this->findByIDorCreate($userData, $provider);
        Auth::login($user, true);

        return $this->userHasLoggedIn();
    }

    /**
     * checkUserExist Check if user details already exist
     * @param  $value
     * @param  $provider
     *
     * @return [object]
     */
    public function checkUserExist($value, $provider)
    {
        $columnName  = $provider.'ID';
        $user = User::where($columnName, $value->getId())->orWhere('username', $value->getNickname())->orWhere('email', $value->getEmail())->first();

        return $user;
    }

    /**
     * getOauth Get the social account details
     *
     * @param  $provider
     * @return [object]
     */
    public function getOauth($provider)
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
     *
     * @return [object]
     */
    public function findByIDorCreate($userData, $provider)
    {
        $columnName  = $provider.'ID';
        $user = $this->checkUserExist($userData, $provider);

        if ($user) {

            User::where('id', $user->id)->update([$columnName => $userData->getId(), 'avatar' => $userData->getAvatar()]);

            return $user;
        }
    }

    /**
     * socialFunction Get Social login type
     *
     * @param  $userData
     * @param  $provider
     */
    public function socialFunction($userData, $provider)
    {
        return $this->getSocialData($userData, $provider);
    }

    /**
     * getSocialData Pass the user details to signup form
     *
     * @param  $userData
     * @param  $provider
     */
    protected function getSocialData($userData, $provider)
    {
        $array = ['username' => $userData->getNickname(), 'email' => $userData->getEmail(), 'facebook' => 0, 'twitter' => 0];
        $array[$provider] = $userData->getId();

        $channels = $this->channelRepository->getAllChannels();
        
        return view('app.pages.signup', compact('channels', 'array'));
    }

}
