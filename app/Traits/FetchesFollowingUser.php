<?php 

namespace App\Traits;

use App\Models\User;

trait FetchesFollowingUser
{
    public function getFollowingUsers(User $user)
    {
        
        $following = $user->followers()->pluck('user_id');
        $followingUser = User::whereIn('id', $following)->get();

       return $followingUser;
    }
}