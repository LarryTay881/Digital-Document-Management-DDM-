<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit_profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->fullName;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            // Delete the old avatar, if it exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store the new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $avatar = basename($avatarPath);
            $user->avatar = $avatar;
        }

        $user->save();

        Toastr::success('Profile updated successfully :)', 'Success');
        return redirect()->route('editProfile');
    }

    public function changePasswordView()
    {
        return view('change_password');
    }

    public function changePasswordDB(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        Toastr::success('Password changed successfully :)', 'Success');
        return redirect()->route('home');
    }
    public function showAvatar($avatar)
    {
        $filePath = storage_path("app/public/avatars/{$avatar}");
        $fileDefault = storage_path("app/public/assets/img/faces/1.jpg");
        if ($avatar == NULL) {
            return response()->file($fileDefault);
        }
        else return response()->file($filePath);
    }
}