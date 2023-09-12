<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Post $post)
    {

        request()->validate([
            'content' => 'required'
        ]);

        $post->comments()->create([
            'user_id' => request()->user()->id,
            'post_id' => $post->id,
            'content' => request('content')

        ]);
        return back();
    }
}
