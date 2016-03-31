<?php

namespace Suyabay\Http\Controllers;

use Validator;
use Hash;
use Suyabay\User;
use Suyabay\Role;
use Suyabay\Invite;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use Suyabay\Http\Controllers\Controller;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Suyabay\Http\Transformers\UserTransformer;

class UserController extends Controller
{
    protected $mail;
    protected $response;
    protected $fractal;

    public function __construct(Manager $fractal) 
    {
        $this->fractal = $fractal;
    }

    /**
     * This method return all users to the calling API endpoint
     */
    public function getAllUsers()
    {
        $users = User::orderBy('id', 'asc')
        ->get([
            'id',
            'username',
            'email',
            'created_at',
            'updated_at',
            'avatar'
        ]);

        $resource = new Collection($users, new UserTransformer());

        if (isset($resource)) {
            $data = $this->fractal->createData($resource)->toArray();

            return Response::json($data, 200);

        }

        return Response::json(['message' => 'Users Not found'], 404);
        
    }

    /**
     * This method return a single user to the calling API endpoint
     */
    public function getSingleUser($id)
    {
        $user = User::where('id', '=', $id)
        ->get([
            'id', 
            'username', 
            'email', 
            'created_at', 
            'updated_at', 
            'avatar'
        ]);

        $resource = new Collection($user, new UserTransformer());

        if (isset($resource)) {
            $data = $this->fractal->createData($resource)->toArray();

            return Response::json($data, 200);

        }

        return Response::json(['message' => 'User Not found'], 404);

    }

    /**
     * This method create a user
     */
    public function postUser(Request $request)
    {
        return $this->validateUserRequest($request);
        
        $users = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email'    => $request->email
        ]);

        if ($users->id) {
            return Response::json(['message' => 'User created successfully'], 200);
        }
    }

    /**
     * This method edit a user
     */
    public function editUser(Request $request, $id)
    {
        return $this->validateUserRequest($request);

        $user = User::find($id);
        $user->username = $request->username;
        $user->email =  $request->email;
        $user->save();

        if ($user->id) {
            return Response::json(['message' => 'User updated successfully'], 201);
        }

    }

    /**
     * This method edit a user
     */
    public function editSingleUser(Request $request, $id)
    {
        if (! isset($id)) {
            return Response::json(['message' => 'User id is missing'], 400);

        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:255'
        ]);

        if ($validator->fails()) {
            return Response::json(['message' => 'User already exist'], 400);
        }

        $user = User::find($id);
        $user->username = $request->username;
        $user->save();

        if ($user->id) {
            return Response::json(['message' => 'User updated successfully'], 200);

        }

    }

    /**
     * This method valdates the user request
     * 
     * @param $request
     * 
     * @return json $response
     */
    public function validateUserRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:255',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['message' => 'User already exist or incomplete fields'], 400);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->paginate(10);

        return view('dashboard.pages.user', compact('users'));
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
