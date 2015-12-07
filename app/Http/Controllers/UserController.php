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
     * Insert invitation details to invites tablee
     *
     * @param  Request $request
     */
    public function createInvite(Request $request)
    {
        $checkUser = Invite::where('username', $request->username)->first();
        if (! $checkUser)
        {
            $createInvite = Invite::create([
                'username'  => $request->username,
                'role_id'  => $request->user_role,
                'token'   => $request->_token
            ]);
            return $createInvite;
        }
    }

    /**
     * Insert into invites table and send mail
     *
     * @param  Request $request
     * @param  $email
     */
    public function processCreateInvite(Request $request, $email)
    {
        if ($this->createInvite($request))
            return $this->sendMail($request, $email);

        return 502;
    }

    /**
     * Check if the user exist and process request.
     *
     * @param  Request $request
     */
    public function sendInvite(Request $request)
    {
        $email = User::where('username', $request->username)->first();
        if ($email)
            return $this->processCreateInvite($request, $email);

        return 501;
    }

    /**
     * Send Invitation mail to selected user
     *
     * @param  $username
     * @param  $token
     * @param  $email
     *
     * @return integer
     */
    public function sendMail(Request $request, $email)
    {
        $mailSent = $this->mail->send('emails.adminInvite', ['username' => $request->username, 'token' => $request->_token], function ($message) use ($email) {
                $message->from(getenv('SENDER_ADDRESS'), getenv('SENDER_NAME'));
                $message->to($email->email)->subject('Suyabay Invitation');
            });

        if ($mailSent)
        {
            return 500;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $roles = Role::get();
        return view('dashboard.pages.create_user', compact('roles'));
    }

    /**
     * Update user role
     *
     * @param  $username
     * @param  $role_id
     */
    public function updateUser($username, $role_id)
    {
        $updateUserRole = User::where('username', $username)->update(['role_id' => $role_id]);
        if ($updateUserRole)
        {
            return $this->deleteToken($username);
        }
    }

    /**
     * Delete user from invite table
     *
     * @param  $token
     */
    public function deleteToken($username)
    {
        $deleteUser = Invite::where('username', $username)->delete();
        if ($deleteUser)
            return redirect('/welcome/'.$username);
    }

    /**
     * process the token from the email when clicked
     *
     * @param  $token
     */
    public function processInvite($token)
    {
        $checkToken = Invite::where('token', $token)->first();
        if ($checkToken)
            return $this->updateUser($checkToken->username, $checkToken->role_id);
    }

    /**
     * Pass users and roles to edit_user view
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $response = "";
        $updateUser = User::where('id', $request->user_id)->update(['role_id' => $request->user_role, 'username' => $request->username]);
        if ($updateUser)
            return 600; // success

        return 601; // Unable to update
    }

    /**
     * Invitation confirmation page
     *
     * @param  $username
     */
    public function welcomePage($username)
    {
        $users = User::where('username', $username)->first();
        return view('app.pages.welcome', compact('users'));
    }
}
