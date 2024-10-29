<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use App\Models\Intern;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;


class PasswordResetController extends Controller
{
    public function showResetRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLink(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);

        // Use the Intern model to find the user
        $intern = Intern::where('email', $request->email)->first();

        if (!$intern) {
            throw ValidationException::withMessages([
                'email' => 'We can\'t find a user with that email address.',
            ]);
        }

        // Generate a password reset token
        $token = app('auth.password.broker')->createToken($intern);

        // Send the reset link email
        Mail::to($intern->email)->send(new ResetPasswordMail($token, $intern->email));

        return back()->with('status', 'Password reset link has been sent!');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        // Find the intern by email
        $intern = Intern::where('email', $request->email)->first();

        // Proceed with password reset if the intern exists
        if ($intern) {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => bcrypt($request->password),
                    ])->save();
                }
            );

            return $status === Password::PASSWORD_RESET
                ? redirect()->route('intern.login')->with('status', __($status))
                : back()->withErrors(['email' => __($status)]);
        }

        return back()->withErrors(['email' => 'The provided email does not match our records.']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Find the intern by email
        $intern = DB::table('interns')->where('email', $request->email)->first();

        if (!$intern) {
            throw ValidationException::withMessages([
                'email' => 'We can\'t find a user with that email address.',
            ]);
        }

        // Update the password
        DB::table('interns')->where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Optionally, delete the password reset token if you're storing it
        // DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }

    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the intern using the email
        $intern = Intern::where('email', $request->email)->first();

        if (!$intern) {
            throw ValidationException::withMessages([
                'email' => 'We can\'t find a user with that email address.',
            ]);
        }

        // Update the password
        $intern->password = Hash::make($request->password);
        $intern->save();

        // Optionally, you can log in the user or send a success message
        return redirect()->route('login')->with('status', 'Your password has been reset successfully!');
    }

    //
}