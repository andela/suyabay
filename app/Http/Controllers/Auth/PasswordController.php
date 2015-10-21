<?php

namespace Suyabay\Http\Controllers\Auth;

use Suyabay\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Suyabay\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;

    protected $redirectTo = '/signin';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Load a password reset page.
     */
    public function passwordPage()
    {
        return view('app.pages.passwordreset');
    }

}
