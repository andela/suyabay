<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Firebase\JWT\JWT;
use Suyabay\AppDetail;
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
    public function myApps()
    {
        return view('api.pages.myapps');
    }

    /**
     * Displays a form where user can register their new app.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewApp()
    {
        return view('api.pages.appform');
    }

    /**
     * Generate a token for user.
     *
     * @return string
     */
    public function generateToken()
    {
        $appSecret    = getenv('APP_SECRET');
        $jwtAlgorithm = getenv('JWT_ALGORITHM');
        $timeIssued   = time();
        $serverName   = getenv('SERVERNAME');
        $tokenId      = base64_encode(getenv('TOKENID'));
        $token        = [
            'iss'  => $serverName,   //Issuer: the server name
            'iat'  => $timeIssued,   // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'nbf'  => $timeIssued, //Not before time
            'exp'  => $timeIssued + 60 * 60 * 24 * 30, // expires in 30 days
        ];
        
        return JWT::encode($token, $appSecret, $jwtAlgorithm);
    }

    /**
     * This method post the details from the user into the database
     *
     */
    public function postNewAppDetails(Request $request)
    {
            $this->validate($request, [
                'name'         => 'required',
                'homepage_url' => 'required|url',
                'description'  => 'required',
            ]);

            AppDetail::create([
            'name'         => $request->name,
            'user_id'      => auth()->user()->id,
            'homepage_url' => $request->homepage_url,
            'description'  => $request->description,
            'api_token'    => $this->generateToken(),
            ]);

            return redirect()->route('developer.app-details');
    }

    /**
     * This method shows the app details created by the user if on session
     * and display an error message if not on session.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNewAppDetails()
    {
            $appDetail = AppDetail::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
           
            return view('api.pages.newappdetails', compact('appDetail'));
        }
}
