<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommunityPostController extends Controller
{
   public function index(Request $request)
   {
   

        $userId = auth()->user()->id;
        $followingIds = $request->user()->following()->pluck('followers.id')->toArray();
        
        
        $followingIds[] = $userId;
        
        $posts = Post::with('author', 'likes', 'comments')
            ->whereNotIn('user_id', $followingIds)
            ->latest()
            ->get();

        return view('community', [
            'posts' => $posts
        ]);
   }
}
