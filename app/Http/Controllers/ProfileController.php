<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Hash;
use Cloudder;
use Redirect;
use Suyabay\User;
use Illuminate\Http\Request;
use Suyabay\Http\Requests;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Repository\UserRepository;

class ProfileController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Gets profile update page.
     *
     * @return Response
     */
    public function getProfileSettings()
    {
        $users = Auth::user();
        return view('profile.settings', compact('users'));
    }
    /**
     * Posts form request.
     *
     * @param  Request $request
     * @return Response
     */
    public function updateProfileSettings(Request $request)
    {
        $updateUser = User::where('id', Auth::user()->id)->update(['username' => $request->username]);

        return redirect('/profile/edit')->with('status', 'You have successfully updated your profile.');
    }

    /**
     *  Posts image update request.
     */
    public function postAvatarSetting(Request $request)
    {
        $this->validate($request, [
            'avatar'  => 'required']);

        $img = $request->file('avatar');
        Cloudder::upload($img, null);
        $imgurl = Cloudder::getResult()['url'];
        $this->user->findUser(Auth::user()->id)->updateAvatar($imgurl);

        return redirect('/profile/edit')->with('status', 'Avatar updated successfully.');

    }

    public function getChangePassword()
    {
        $users = Auth::user();
        return view('profile.changepassword', compact('users'));
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password'     => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Compare old password
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Old password incorrect']);
        }

        // Update current password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('status', 'Password successfully updated');
    }
}