<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LogoutController extends Controller
{
   /**
     * Log the user out and redirect to the login page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session to prevent session fixation attacks
        $request->session()->invalidate();

        // Regenerate the CSRF token to prevent further use of the same session
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('welcome');
    } //
}
