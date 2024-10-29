<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Booking;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class AdminAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('pages.admin.register');
    }






    // Handle Admin Registration
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'admin_id' => 'required|string|unique:admins,admin_id',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Create the admin and save to the 'admins' table
        Admin::create([
            'admin_name' => $request->admin_name,
            'admin_id' => $request->admin_id,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
        ]);

        // Redirect to login page with success message
        return redirect()->route('pages.admin.login')->with('success', 'Registration successful! Please login.');
    }
    // Show Admin Login Form
    public function showLoginForm()
    {
        return view('pages.admin.login');
    }

    // Handle Admin Login
    public function login(Request $request)
    {
        // Validate the login details
        $request->validate([
            'admin_id' => 'required|string',
            'password' => 'required',
        ]);

        // Check if admin exists in the admins table
        $admin = Admin::where('admin_id', $request->admin_id)->first();

        // If admin exists and password matches
        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::login($admin); // Login the admin
            return redirect()->route('admin.view'); // // Redirect to the admin store/dashboard
        } else {
            // If admin does not exist or password mismatch, show error
            return back()->withErrors(['login_error' => 'Invalid Admin ID or Password']);
        }

    }

    // Logout Admin
    public function logout()
    {
        Auth::logout();
        return redirect()->route('pages.admin.login')->with('success', 'Logged out successfully!');
    }


}