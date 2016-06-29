<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Hash;
use Validator;
use Suyabay\User;
use Suyabay\Role;
use Suyabay\Invite;
use Suyabay\Http\Requests;
use Suyabay\AccountUpgrade;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Requests\AccountUpgradeRequest;

class UserController extends Controller
{
    protected $mail;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->paginate(12);

        return view('dashboard.pages.user', compact('users'));
    }

    /**
     * This method loads a new form that enables a regular user
     * to request for a premium account.
     *
     * @param void
     *
     * @return view
     */
    public function requestAccountUpgrade()
    {
        return view('app.pages.request-premium-account');
    }

    /**
     * This method post the regular user request for account upgrade
     *
     * @param Request $request
     *
     * @return view
     */
    public function postAccountUpgrade(AccountUpgradeRequest $request)
    {
        $verifyUser = User::where('email', $request->input('email'))->first();

        if (!is_null($verifyUser)) {
            if (!is_null($this->createUserAccountUpgrade($request))) {
                return redirect()
                ->back()
                ->with('status', 'Your request was submitted, we will get back to you soon!');
            }

            return redirect()->back()->with('error', 'Oops! something went wrong!');

        }

        return redirect()->back()->with('error', 'Email address is invalid!');
    }

    /**
     * This method creates the user request for account upgrade from regular to premium
     *
     * @param $request
     *
     * @return AccountUpgrade
     */
    private function createUserAccountUpgrade($request)
    {
        return AccountUpgrade::create([
            'user_id' => Auth::user()->id,
            'reason'  => $request->input('reason'),
        ]);
    }

    /**
     * This method gets all the regular users request for a premium account upgrade.
     *
     * @param void
     *
     * @return view
     */
    public function viewUserRequestForAccountUpgrade()
    {
        $accountUpgradeRequests  = AccountUpgrade::orderBy('id', 'desc');
        $paginatedUpgradeRequest = $accountUpgradeRequests->paginate(10);

        return view('dashboard.pages.view_upgrade_request', compact('paginatedUpgradeRequest', 'countUpgradeRequest'));
    }

    /**
     * Check if user exist
     *
     * @param  $request
     */
    public function checkIfUserExist(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if ($user) {
            return true;
        }
    }

    /**
     * Insert invitation into database
     *
     * @param  $request
     */
    public function createInvitation(Request $request)
    {
        try {
            Invite::create([
                'username'  => $request->username,
                'role_id'  => $request->user_role,
                'token'   => $request->_token
            ]);
            $this->response =
            [
                'message' => 'Invitation created',
                'status_code' => 201
            ];
        } catch (QueryException $e) {
            $this->response =
            [
                'message' => 'Invitation already sent',
                'status_code' => 400
            ];
        }

        return $this->response;
    }

    /**
     * Check if user exist and Insert Invitation details
     * into the database
     *
     * @param  $request
     */
    public function insertInvite(Request $request)
    {
        if ($this->checkIfUserExist($request)) {
            $this->response = $this->createInvitation($request);
        } else {
            $this->response =
            [
                'message' => 'User does not exist',
                'status_code' => 400
            ];
        }

        return $this->response;
    }

    /**
     * Process invitation details into invites table
     *
     * @param  Request $request
     */
    public function createInvite(Request $request)
    {
        $createInvite = $this->insertInvite($request);

        if ($createInvite['status_code'] == 201) {
            $this->response = $this->getInviteeEmail($request);
        } else {
            $this->response =
            [
                'message' => $createInvite['message'],
                'status_code' => $createInvite['status_code']
            ];
        }

        return $this->response;
    }

    /**
     * Get Invitee email and process mail
     *
     * @param  Request $request
     */
    public function getInviteeEmail(Request $request)
    {
        $email = User::where('username', $request->username)->first();

        if ($email) {
            $this->response = $this->sendMail($request, $email);
        }

        return $this->response;
    }

    /**
     *
     * Get the role name
     *
     * @param  $role_id
     */
    public function getRoleName($id)
    {
        $role = Role::find($id);

        return $role->name;
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
        $mailSent = $this->mail->send('emails.adminInvite', [
            'username' => $request->username,
            'role' => $this->getRoleName($request->user_role),
            'token' => $request->_token], function ($message) use ($email) {
                $message->from(getenv('SENDER_ADDRESS'), getenv('SENDER_NAME'));
                $message->to($email->email)->subject('Suyabay Invitation');
            });

        if ($mailSent) {
            $this->response = ['message' => 'Invitation was sent successfully', 'status_code' => 201];
        }

        return $this->response;
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

        if ($updateUserRole) {
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

        if ($deleteUser) {
            return redirect('/welcome/'.$username);
        }
    }

    /**
     * process the token from the email when clicked
     *
     * @param  $token
     */
    public function processInvite($token)
    {
        $checkToken = Invite::where('token', $token)->first();

        if ($checkToken) {
            $this->response = $this->updateUser($checkToken->username, $checkToken->role_id);
        } else {
            $this->response = redirect('/invalid');
        }

        return $this->response;
    }

    /**
     * Pass users and roles to edit_user view
     *
     * @param  int  $id
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
        $updateUser = User::where('id', $request->user_id)->update(['role_id' => $request->user_role, 'username' => $request->username]);

        if ($updateUser) {
            $user = User::where('username', $request->username)->first();

            if (!is_null($user)) {
                AccountUpgrade::where('user_id', $user->id)
                ->delete();
            } else {
                return [
                    'message' => 'User not found',
                    'status_code' => 404
                ];
            }

            
            $this->response =
            [
                'message' => 'User details updated successfully',
                'status_code' => 201
            ];
        } else {
            $this->response =
            [
                'message' => 'Error updating user',
                'status_code' => 400
            ];
        }

        return $this->response; // Unable to update
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
