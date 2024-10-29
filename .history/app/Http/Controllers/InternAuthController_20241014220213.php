<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class InternAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('pages.intern.register');
    }



    public function register(Request $request)
    {
        $request->validate([
            'intern_name' => 'required|string|max:255',
            'intern_id' => 'required|string|unique:interns,intern_id',
            'email' => 'required|email|unique:interns,email',
            'password' => 'required|confirmed|min:6',
        ]);

        Intern::create([
            'intern_name' => $request->intern_name,
            'intern_id' => $request->intern_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('intern.login');

    }

    public function showLoginForm()
    {
        return view('pages.intern.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'intern_id' => 'required|string',
            'password' => 'required',
        ]);
    
        $intern = Intern::where('intern_id', $request->intern_id)->first();
        \Log::info('Login attempt:', ['intern_id' => $request->intern_id, 'intern_found' => $intern ? 'Yes' : 'No']);
    
        if ($intern && Hash::check($request->password, $intern->password)) {
            Auth::login($intern);
            session(['intern_name' => $intern->intern_name, 'intern_id' => $intern->intern_id]);
    
            // Debugging output
            \Log::info('Session values after login:', [
                'intern_id' => session('intern_id'),
                'intern_name' => session('intern_name'),
            ]);
            \Log::info('Intern logged in:', ['intern_id' => $intern->intern_id]);
    
            return redirect()->route('intern.booking');
        } else {
            \Log::error('Invalid login attempt:', ['intern_id' => $request->intern_id]);
            return back()->withErrors(['login_error' => 'Invalid Intern ID or Password']);
        }
    }
    

    public function booking()
    {
        // Retrieve intern details from the session
        $intern_id = session('intern_id');
        $intern_name = session('intern_name');

        // Check if the intern details exist in the session
        if (!$intern_id || !$intern_name) {
            return redirect()->route('intern.login')->withErrors(['login_error' => 'Please log in first']);
        }

        // Return the booking view with intern details
        return view('pages.intern.booking', compact('intern_id', 'intern_name'));
    }

    public function create()
    {
        return view('pages.intern.register');
    }

    // Store new intern
    public function store(Request $request)
    {
        // Validate registration input
        $request->validate([
            'name' => 'required|string|max:255',
            'intern_id' => 'required|unique:interns',
            'password' => 'required|string|min:6|confirmed',  // Ensure password confirmation is included
        ]);

        // Create a new intern
        Intern::create([
            'name' => $request->name,
            'intern_id' => $request->intern_id,
            'password' => Hash::make($request->password),  // Hash the password
        ]);

        // Redirect to login with success message
        return redirect()->route('intern.login')->with('success', 'Registration successful, please log in.');
    }


    public function showBookingPage()
    {
        return view('pages.intern.booking');

   }

    //
}