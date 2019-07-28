<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notifications\Followed;

class ProfileController extends Controller
{
    public function profile(User $user)
    {
        return view('profile.detail', compact('user'));
    }

    public function update(Request $request)
    {
        //  @TODO: bu validation hatalarını önyüzde gösterelim
        $request->validate([
            'displayname' => 'nullable|string|min:1|max:50',
            'birth_date' => 'nullable|date',
            'profileimage' => 'nullable|image|max:3000'
        ]);

        $user = $request->user();
        $user->displayname = $request->input('displayname');
        $user->birth_date = $request->input('birth_date');
        if ($request->hasFile('profileimage')) {
            // @TODO: önceden bir profil fotoğrafı varsa onu kaldıralım
            $path = $request->file('profileimage')->store('public/images');
            $user->profileimage = $path;
        }
        $user->save();

        return redirect()->route('profile', $user);  
    }

    public function follow(User $user, Request $request)
    {
        $request->user()->follow($user);
        return redirect()->route('profile', $user);
    }

    public function unfollow(User $user, Request $request)
    {
        $request->user()->unfollow($user);
        return redirect()->route('profile', $user);
    }
}
