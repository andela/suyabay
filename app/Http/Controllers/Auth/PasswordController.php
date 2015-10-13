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
        // $this->validate($request, ['email' => 'required|email']);
        $response = [];
        $status = User::whereEmail($request->only('email'))->first();
        if ( $status == false )
        {
            $response =
            [
                "message"       => "Invalid",
                "status_code"   => 401,
            ];
        }
        else
        {
            $response =
            [
                "message"       => "success",
                "status_code"   => 200,
            ];
        }
        return $response;
    }
}
