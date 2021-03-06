<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Alert;
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
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $userData     = Socialite::driver($provider)->user();
        
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
        alert()->success('Your have successfully Sign In', 'success');

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
        $columnName  = $provider.'ID';
        User::create([
            'username'       => $userData->getNickname() ?: $userData->getName(),
            'password'       => bcrypt(str_random(10)),
            'email'          => $userData->getEmail() ?: str_random(10).'@noemail.app',
            'avatar'         => $userData->getAvatar(),
            'role_id'        => 1,
            $columnName      => $userData->getId()
        ]);

        $user = $this->findByIDorCreate($userData, $provider);
        Auth::login($user, true);
        alert()->success('Your have successfully signUp', 'success');

        return redirect('/');
    }
}
