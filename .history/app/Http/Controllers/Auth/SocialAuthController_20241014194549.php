<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Adjust according to your user model

class SocialAuthController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->createOrUpdateUser($user);
        return redirect()->route('home'); // Change this to the route you want to redirect after login
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->createOrUpdateUser($user);
        return redirect()->route('home'); // Change this to the route you want to redirect after login
    }

    private function createOrUpdateUser($socialUser)
    {
        // Find or create the user
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(uniqid()), // or generate a random password
            ]);
        }

        Auth::login($user, true);
    }
}
