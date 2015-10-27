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

    public function postEmailMs(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $response = [];

        //check if email exist (ajax call)
        $status = User::whereEmail($request->only('email'))->first();
        if ( $status == false )
        {
            return $response =
            [
                "message"       => "Invalid",
                "status_code"   => 401,
            ];
        }
        else
        {
            $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject($this->getEmailSubject());
            });

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return redirect()->back()->with('status', trans($response));

                case Password::INVALID_USER:
                    return redirect()->back()->withErrors(['email' => trans($response)]);
            }
        }
    }
}
