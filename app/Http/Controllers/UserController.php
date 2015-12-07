<?php

namespace Suyabay\Http\Controllers;

use Suyabay\User;
use Suyabay\Role;
use Suyabay\Invite;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer as Mail;
use Suyabay\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $mail;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->paginate(10);

        return view('dashboard.pages.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        //check user in db
        $createInvite = Invite::create([
            'username'  => $request->username,
            'role_id'  => $request->user_role,
            'token'   => $request->_token
        ]);
        // return $createInvite;
        $email = User::where('username', $request->username )->first()->email;
        // dd($email);
        $this->mail->send('emails.adminInvite', ['username' => $request->username, 'token' => $request->_token], function ($message) use ($email)
        {
            $message->from( getenv('SENDER_ADDRESS'), getenv('SENDER_NAME'));
            $message->to($email)->subject('Welcome To Suyabay');
        });
        //update invitation
        //get email
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $roles = Role::get();
        return view('dashboard.pages.create_user', compact('roles'));
    }

    /**
     * process the token from the email when clicked
     *
     * @param  $token
     */
    public function processInvite($token)
    {
        $checkToken = Invite::where('token', $token)->first();
        if( $checkToken )
        {
            $updateUserRole = User::where('username', $checkToken->username)->update(['role_id' => $checkToken->role_id]);
            if( $updateUserRole )
            {
                return Invite::where('username', $checkToken->username)->delete();
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editView($id)
    {
        $users = User::where('id', $id)->first();
        $roles = Role::get();
        return view('dashboard.pages.edit_user', compact('users', 'roles'));
    }

    public function edit($id)
    {
        // return view('dashboard.pages.edit_user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response = "";
        $e = User::where('id', $request->user_id)->update(['role_id' => $request->user_role, 'username' => $request->username]);
        if ( $e )
        {
            $response = 600; // success
        } else {
            $response = 601; // Unable to update
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
