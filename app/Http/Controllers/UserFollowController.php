<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\FollowerGained;


class UserController extends Controller
{
    public function toggleFollow(Request $request)
    {

        $author = User::find($request->author['id']);
        $authenticatedUser = User::find(auth()->user()->id);


        if ($authenticatedUser->following()->where('follower_id', $author->id)->exists()) {
            $authenticatedUser->following()->detach($author->id);
            return response()->json(['message' => 'You are no longer following this user.']);
        }

        $authenticatedUser->following()->attach($author->id);

        event(new FollowerGained($authenticatedUser, $author));

        return redirect()->back();
    }
}
