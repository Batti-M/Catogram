<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('post_image')) {
            return redirect()->back()->with('error', 'Please upload an image.');
        }

        $attributes = $request->validate([
            'post_image' => ['file', 'image', 'mimes:jpg,png,jpeg', 'max:7000', 'required'],
            'description' => ['string', 'max:255'], // 'nullable
            'content' => ['required', 'min:3'],
        ]);

        $attributes['user_id'] = request()->user()->id;
        $attributes['post_image']  = $request->file('post_image')->store('images', 'public');

        Post::create($attributes);

        return to_route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        $post = Post::where('id', $post->id)->with('author', 'likes', 'comments')->firstOrFail();
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $attributes = $request->validate([
            'description' => ['string', 'max:255'], // 'nullable
            'content' => ['required', 'min:3'],
        ]);

        $post->update($attributes);

        return to_route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return to_route('home');
    }
}
