<?php

namespace Suyabay\Http\Controllers\Auth;

use Auth;
use Alert;
use Validator;
use Socialite;
use Suyabay\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer as Mail;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Requests\RegisterRequest;
use Suyabay\Http\Repository\ChannelRepository;
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
    protected $redirectTo   = '/login';
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
        $this->channelRepository = new ChannelRepository();
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
            'avatar'        => null
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
        $channels = $this->channelRepository->getAllChannels();

        return view('app.pages.signup', compact('channels'));
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
        $channels = $this->channelRepository->getAllChannels();

        return view('app.pages.login', compact('channels'));
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
            /*
            # Update user acive column to 1 when user successfully signin
            */
            
            $data = [
                'active' => 1, // Set the user to be active.
                'has_viewed_new' => 0, // Set user has not viewed notifications page.
            ];
            
            Auth::user()->update($data);
            
            return $response =
            [
                "message"       => "login success",
                "status_code"   => 200,
            ];
        }

        return redirect()->intended('/');
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
        /*
        * Update user acive column to 0 when user successfully signout
        */
        $user = Auth::user();
        
        $data = [
            'active' => 0
        ];

        $logout = $user->update($data);

        if ($logout) {

            // If the user has viewed his notifications page, update his logout information.
            // if ($user->has_viewed_new) {
                $user->saveLoggedOutTime();
            // }

            Auth::logout();

            return redirect('/');
        }
    }
}
