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

class ProfileController extends Controller
{
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
        $input = $request->except('_token', 'url');
        User::find(Auth::user()->id)->updateProfile($input);

        return redirect('/profile/edit')->with('status', 'You have successfully updated your profile.');
    }

    /**
     *  Posts image update request.
     */
    public function postAvatarSetting(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $img = $request->file('avatar');

            Cloudder::upload($img);
            $imgurl = Cloudder::getResult()['url'];

            User::find(Auth::user()->id)->updateAvatar($imgurl);

            return redirect('/profile/edit')->with('status', 'Avatar updated successfully.');
        } else {
            return redirect('/profile/edit')->with('status', 'Please select an image.');
        }
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
        if (!Hash::check($request->get('old_password'), $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Old password incorrect']);
        }

        // Update current password
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect()->back()->with('status', 'Password successfully updated');
    }
}
