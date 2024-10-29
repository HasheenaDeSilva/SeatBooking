<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.Home.index');
    }//

    public function handleSelection(Request $request)
    {
        $request->validate([
            'user_type' => 'required|in:intern,admin',
        ]);

        // Store the user type in the session
        session(['user_type' => $request->user_type]);

        // Redirect to the appropriate welcome page
        return redirect()->route('welcome.' . $request->user_type);
    }
}
