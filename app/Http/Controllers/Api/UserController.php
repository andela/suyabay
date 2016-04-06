<?php

namespace Suyabay\Http\Controllers\Api;

use Validator;
use Suyabay\User;
use Suyabay\Http\Requests;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use Illuminate\Mail\Mailer as Mail; 
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Response;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Transformers\UserTransformer;

class UserController extends Controller
{
    protected $mail;
    protected $response;
    protected $fractal;

    public function __construct(Manager $fractal, Mail $mail)
    {
        $this->fractal = $fractal;

        parent::__construct($mail);
    }

    /**
     * This method return all users to the calling API endpoint
     */
    public function getAllUsers(Request $request, UserTransformer $userTransformer)
    {
        $limit = $request->query('results') ? : 10;
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

        $resource = new Collection($users, $userTransformer);
        $data = $this->fractal->createData($resource)->toArray();

        if (count($data['data']) > 0) {
            return Response::json($data, 200);

        }
        
        return Response::json(['message' => 'User records not available for display'], 404);
    
    }

    /**
     * This method return a single user to the calling API endpoint getMyDetails
     */
    public function getSingleUser($username, UserTransformer $userTransformer)
    {
        $user = $this->userRepository->findUserWhere($username);

        if (! is_null($user)) {
            $resource = new Item($user, $userTransformer);
            $data = $this->fractal->createData($resource)->toArray();

            return Response::json($data, 200);

        }

        return Response::json(['message' => 'User Not found'], 404);

    }

    /**
     * This method return a single user to the calling API endpoint
     */
    public function getMyDetails(UserTransformer $userTransformer)
    {
        $id  = 1; // The id will be retrieved from the token

        $user = $this->userRepository->findUser($id)->first();

        if (! is_null($user)) {
            $resource = new Item($user, $userTransformer);
            $data = $this->fractal->createData($resource)->toArray();

            return Response::json($data, 200);

        }

        return Response::json(['message' => 'User Not found'], 404);

    }

    /**
     * This method edit a user
     */
    public function editUser(Request $request, $id)
    {
        if ($this->validateUserRequestForEmptyFields($request)) {
            return Response::json(['message' => 'All fields must be filled'], 400);

        }

        if ($this->validateUserRequest($request)) {
            return Response::json(['message' => 'User already exists'], 400);

        }

        $user = User::find($id);
        $user->username = $request->username;
        $user->email =  $request->email;
        $user->save();

        if ($user->id) {
            return Response::json(['message' => 'User updated successfully'], 200);

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
     * This method validates the user request for empty fields
     * 
     * @param $request
     * 
     * @return json $response
     */
    public function validateUserRequestForEmptyFields($request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:50',
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return true;
        }
    }

    /**
     * This method validates the user request
     * 
     * @param $request
     * 
     * @return json $response
     */
    public function validateUserRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return true;
        }
    }

}
