<?php

namespace App\Http\Controllers;

use App\Models\Post;


class LikeController extends Controller
{
    public function toggleLike(Post $post)
    {


        if ($post->likes()->where('user_id', auth()->user()->id)->exists()) {

            $post->likes()->where('user_id', auth()->user()->id)->delete();

            return redirect()->back();
        } else {

            $post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            return redirect()->back();
        }
    }
}
