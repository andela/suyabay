<?php

namespace Suyabay\Http\Controllers\Auth;

use Auth;
use Validator;
use Socialite;
use Suyabay\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer as Mail;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $mail;
    protected $loginPath    = '/login';
    protected $registerPath = '/register';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        User::create([
            'email'         => $data['email'],
            'username'      => $data['username'],
            'password'      => bcrypt($data['password']),
            'facebookID'    => $data['facebook'],
            'twitterID'     => $data['twitter'],
            'avatar'        => NULL
        ]);

        /*Send Email*/
        $this->mail->send('emails.welcome', ['name' => $data['username']], function ($message) use ($data)
        {
            $message->from( getenv('SENDER_ADDRESS'), getenv('SENDER_NAME'));
            $message->to($data['email'])->subject('Welcome To Suyabay');
        });
    }

    /**
     * Register a new user instance.
     *
     * @param Request $request
     *
     * @return home
     */
    public function register()
    {
        return view('app.pages.signup');
    }

    /**
     * Register a new user instance.
     *
     * @param Request $request
     *
     * @return home
     */
    public function postRegister(Request $request)
    {
        $email              = $request->email;
        $username           = $request->username;
        $checkUserExists    = User::where('username', '=', $username)->get();
        $checkEmailExists   = User::where('email', '=', $email)->get();

        if ( $checkEmailExists->count() === 1 OR $checkUserExists->count() === 1 )
        {
            return $response =
            [
                "message"       => "Registration Failed",
                "status_code"   => 401
            ];
        }
        else
        {
            $this->create($request->all());
            return $response =
            [
                "message"       => "Registration Successful",
                "status_code"   => 200
            ];
        }
    }



    /**
     * Login a exisitng instance of user.
     *
     * @param Request $request
     *
     * @return home
     */
    public function login()
    {
        return view('app.pages.login');
    }

     /**
     * Login a exisitng instance of user.
     *
     * @param Request $request
     *
     * @return home
     */
    public function postLogin(Request $request)
    {
        $status = Auth::attempt($request->only(['username', 'password']));
        if ( ! $status )
        {
            return $response =
            [
                "message"       => "login failed",
                "status_code"   => 401,
            ];
        }
        else
        {
            return $response =
            [
                "message"       => "login success",
                "status_code"   => 200,
            ];
        }
    }

    /**
     * Logout current user.
     *
     * @param Request $request
     *
     * @return home
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
