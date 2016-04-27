<?php

namespace Suyabay\Http\Controllers\Api;

use Auth;
use Firebase\JWT\JWT;
use Suyabay\AppDetail;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Suyabay\Http\Controllers\Controller;

class PagesController extends Controller
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
     * If the user has no app yet, display a page where he can create a new one
     *
     * @return \Illuminate\Http\Response
     */
    public function showMyApps()
    {
        $allApps = AppDetail::where('user_id', auth()->user()->id)->paginate(5);

        if ($allApps->isEmpty()) {
            return view('api.pages.myapps');
        }

        return view('api.pages.allappdetails', compact('allApps'));
    }

    /**
     * Displays a form where user can register there new app.
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
            'iss'  => $serverName,    //Issuer: the server name
            'iat'  => $timeIssued,    // Issued at: time when the token was generated
            'jti'  => $tokenId,      // Json Token Id: an unique identifier for the token
            'nbf'  => $timeIssued,   //Not before time
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

        $returnData = AppDetail::create([
            'name'         => $request->name,
            'user_id'      => auth()->user()->id,
            'homepage_url' => $request->homepage_url,
            'description'  => $request->description,
            'api_token'    => $this->generateToken(),
        ]);

        if (is_null($returnData->id)) {
            return redirect()->back()->with('info', 'Oops, App creation Unsuccessfull');
        }

        return redirect()->route('developer.newapp-details')->with('info', 'App created Successfully');
    }

    /**
     * This method shows the app details created by the user if on session
     * and display an error message if not on session.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNewAppDetails()
    {
        $appDetails = AppDetail::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
    
        return view('api.pages.newappdetails', compact('appDetails'));
    }

    /**
     * This method shows the app details created by the user if on session
     * and display an error message if not on session.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAppDetails($id)
    {
        $appDetails = AppDetail::where('user_id', auth()->user()->id)->find($id);
        
        return view('api.pages.appdetails', compact('appDetails'));
    }
}
