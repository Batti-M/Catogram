<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback($provider)
    {
        $oauthUser = Socialite::driver($provider)->user();
        $user = $this->findOrCreateUser($oauthUser, $provider);

        Auth::login($user, true);

        return redirect()->intended('/explore');
    }

    public function findOrCreateUser($oauthUser, $provider)
    {
        $user = User::whereEmail($oauthUser->getEmail())
            ->orWhereHas('oauth', fn ($query) => $query->where([
                'provider_name' => $provider,
                'provider_id' => $oauthUser->getId(),
            ]))->first();

        if ($user){
            return $user;
        }
        
        $user = User::create([
            'name' => $name = $oauthUser->getName(),
            'email' => $oauthUser->getEmail(),
            'username' => $name,
            'password' => null,
        ]);

        $user->oauth()->create([
            'user_id' => $user->id,
            'provider_name' => $provider,
            'provider_id' => $oauthUser->getId(),
        ]);

        return $user;
    }
}
