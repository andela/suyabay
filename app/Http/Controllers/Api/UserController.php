<?php

namespace Suyabay\Http\Controllers\Api;

use Validator;
use Suyabay\User;
use Suyabay\Http\Requests;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Response;
use Suyabay\Http\Controllers\Controller;
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
    public function getAllUsers(Request $request)
    {
        $limit = 10;

        $currentPage = $request->query('page') ? : 1;

        $recordsToSkip = (int) ($limit * $currentPage) - $limit;

        $users = User::orderBy('id', 'asc')
        ->skip($recordsToSkip)
        ->take($limit)
        ->get([
            'id',
            'username',
            'email',
            'created_at',
            'updated_at',
            'avatar'
        ]);

        $resource = new Collection($users, new UserTransformer);

        $data = $this->fractal->createData($resource)->toArray();

        if (count($data['data']) > 0) {
            return Response::json($data, 200);

        }
        
        return Response::json(['message' => 'User record not available for display'], 404);
    
    }

    /**
     * This method return a single user to the calling API endpoint getMyDetails
     */
    public function getSingleUser($username)
    {
        $user = User::where('username', '=', $username)
        ->first([
            'id',
            'username',
            'email',
            'created_at',
            'updated_at',
            'avatar'
        ]);

        $resource = new Item($user, new UserTransformer);

        $data = $this->fractal->createData($resource)->toArray();

        if (count($data['data']) > 0) {
            return Response::json($data, 200);

        }

        return Response::json(['message' => 'User record not available for display'], 404);

    }

    /**
     * This method return a single user to the calling API endpoint
     */
    public function getMyDetails()
    {
        $id  = 1; // The id will be retrieved from the token

        $user = User::where('id', '=', $id)
        ->first([
            'id',
            'username',
            'email',
            'created_at',
            'updated_at',
            'avatar'
        ]);

        $resource = new Item($user, new UserTransformer);

        $data = $this->fractal->createData($resource)->toArray();

        if (count($data['data']) > 0) {
            return Response::json($data, 200);
        
        }

        return Response::json(['message' => 'User Not found'], 404);

    }

    /**
     * This method edit a user
     */
    public function editUser(Request $request, $id)
    {
        if ($this->validateUserRequest($request)) {
            return Response::json(['message' => 'User already exist or incomplete fields'], 400);

        }

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
            return true;
        }
    }

}
