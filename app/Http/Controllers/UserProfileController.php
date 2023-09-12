<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\FetchesFollowingUser;

class UserProfileController extends Controller
{
    use FetchesFollowingUser;
    public function index(User $user)
    {

        return view('User.profile',  [
            'user' => $user,
            'followingUser' => $this->getFollowingUsers($user)
        ]);
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }



}
