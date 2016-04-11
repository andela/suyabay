<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Suyabay\AppInfo;
use Firebase\JWT\JWT;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Suyabay\Http\Controllers\Controller;

class ApiPagesController extends Controller
{
    /**
     * Displays the index page of the API.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('api.pages.index');
    }

    /**
     * Display list of apps the user have created and a link to create new appp.
     *
     * @return \Illuminate\Http\Response
     */
    public function myApp()
    {
        return view('api.pages.myapp');
    }

    /**
     * Displays a form where user can register their new app.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewApp()
    {
        return view('api.pages.mynewapp');
    }

    /**
     * Generate a token for user.
     *
     * @param int $userId
     *
     * @return string
     */
    public function generateToken()
    {
        $appSecret = getenv('APP_SECRET');
        $jwtAlgorithm = getenv('JWT_ALGORITHM');
        $timeIssued = time();
        $serverName = getenv('SERVERNAME');
        $tokenId = base64_encode(getenv('TOKENID'));
        $token = [
            'iss'  => $serverName,   //Issuer: the server name
            'iat'  => $timeIssued,   // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'nbf'  => $timeIssued, //Not before time
            'exp'  => $timeIssued + 60 * 60 * 24 * 30, // expires in 30 days
        ];
        
        return JWT::encode($token, $appSecret, $jwtAlgorithm);
    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function postAppDetails(Request $request)
    {
        AppDetail::create([
        'name'         => $request->name,
        'homepage_url' => $request->homepage_url,
        'description'  => $request->description,
        'api_token'    => $this->generateToken(),
        ]);
    }
}

