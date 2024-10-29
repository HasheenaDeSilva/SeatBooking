<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthController extends Controller
{
    public function facebookpage()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookredirect()
    {
        try {
            
            // Authenticate the user with Facebook
            // $user = Socialite::driver('facebook')->stateless()->user();

            // // Log in the user without storing details
            // Auth::loginUsingId(1, true); // Assumes a generic user ID of 1 or a fixed ID for all Facebook logins
            \Log::info('facebookredirect method called');

            // Redirect to the booking page
            return redirect()->route('intern.bookingnew'); 

        } catch (Exception $e) {
           
            return redirect()->route('login')->withErrors(['msg' => 'Failed to login with Facebook.']);
        }
    }




    

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
           
            \Log::info('redirectToGoogle method called');

            return redirect()->route('intern.bookingnew');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to log in with Google.');
        }
    }



    private function createOrUpdateUser($socialUser, $provider)
    {
        
        $user = Intern::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            
            $user = Intern::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider, 
                'password' => bcrypt(uniqid()), 
            ]);
        }

        Auth::login($user, true); 
    }
}