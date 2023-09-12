<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Traits\FetchesFollowingUser;

class HomeController extends Controller
{
    use FetchesFollowingUser;
    public function index()
    {
        $posts = Post::where('user_id', auth()->user()->id)->with('author', 'likes', 'comments')->latest()->get();
        return view('home', [
            'user' => auth()->user(),
            'posts' => $posts,
            'followingUser' => $this->getFollowingUsers(auth()->user())
        ]);
    }
}
