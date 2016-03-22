<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Hash;
use Cloudder;
use Redirect;
use Suyabay\User;
use Illuminate\Http\Request;
use Suyabay\Http\Repository\UserRepository;

class ProfileController extends Controller
{
    /**
     * Gets profile update page.
     *
     * @return Response
     */
    public function getProfileSettings()
    {
        $channels = $this->channelRepository->getAllChannels();
        $users = Auth::user();

        return view('profile.settings', compact('users', 'channels'));
    }
    /**
     * Posts form request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function updateProfileSettings(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:255|unique:users,username,'. Auth::user()->id,
        ]);

        $updateUser = User::where('id', Auth::user()->id)->update(['username' => $request->username]);

        return redirect('/profile/edit')->with('status', 'You have successfully updated your profile.');
    }

    /**
     *  Posts image update request.
     */
    public function postAvatarSetting(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required',
        ]);

        $img = $request->file('avatar');
        Cloudder::upload($img, null);
        $imgurl = Cloudder::getResult()['url'];

        $this->userRepository->findUser(Auth::user()->id)->updateAvatar($imgurl);

        return redirect('/profile/edit')->with('status', 'Avatar updated successfully.');
    }

    public function getChangePassword()
    {
        $channels = $this->channelRepository->getAllChannels();
        $users = Auth::user();

        return view('profile.changepassword', compact('users', 'channels'));
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
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
