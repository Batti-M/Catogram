<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        
        $user = User::find(auth()->user()->id);
        $attributes = $request->validate([
            'name' => 'string', 'max:255',
            'username' => 'required', 'string', 'max:255', 'unique:users',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'profile_image' => ['file', 'image', 'mimes:jpg,png,jpeg', 'max:7000', 'required'],
        ]);

        if ($request->hasFile('profile_image')) {
            $attributes['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
          }

        $user->update($attributes);

        return redirect()->route('user-profile', $user->username);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
