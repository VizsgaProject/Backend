<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PasswordController extends Controller
{
    public function showResetForm($token)
    {
        // Find the user with the given token
        $user = User::where('reset_password_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid token.');
        }

        // Show the reset password form with the token
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the user by email and token
        $user = User::where('email', $request->email)
            ->where('reset_password_token', $request->token)
            ->first();

        if (!$user) {
            return redirect()->route('reset.password', ['token' => $request->token])
                ->with('error', 'Invalid email or token.');
        }

        // Update the user's password
        $user->password = bcrypt($request->password);
        $user->reset_password_token = null; // Clear the token
        $user->save();

        // return redirect()->route('login')->with('success', 'Your password has been reset successfully.');
    }
}
