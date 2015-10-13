<?php

namespace Suyabay\Http\Controllers\Auth;

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

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function passwordPage()
    {
        return view('app.pages.passwordreset');
    }

    public function checkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));
        if ( $status === false )
        {
            return $response =
            [
                "message"       => "Invalid",
                "status_code"   => 401,
            ];
        }
        else
        {
            return $response =
            [
                "message"       => "success",
                "status_code"   => 200,
            ];
        }
        dd($response);
    }
}
