<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $ownPosts = Post::where('user_id', auth()->user()->id)->latest()->get();

        $followingPosts = $request->user()->following()->with('posts.author', 'likes', 'comments')->get()->pluck('posts')->flatten();
        
        $posts = $ownPosts->merge($followingPosts)->sortByDesc('created_at');

        return view('explore', [
            'posts' => $posts
        ]);
    }
}
