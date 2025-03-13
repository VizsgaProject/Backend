<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SendMailController extends Controller
{
    public function sendMail(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Hibás email cím.', 'errors' => $validator->errors()], 400);
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Nem található felhasználó ezzel az email címmel.'], 404);
        }

        // Generate a reset token
        $token = Str::random(60);

        // Save the reset token to the database
        $user->reset_password_token = $token;
        $user->save();

        // Prepare email data
        $mailData = [
            'user' => $user->name,  // User's name
            'email' => $user->email, // User's email
            'token' => $token,      // Reset token
        ];

        // Send email
        try {
            Mail::to($user->email)->send(new ResetPassword($mailData));
            return response()->json(['message' => 'Az emailt sikeresen elküldtük.'], 200);
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return response()->json(['message' => 'Az emailt nem sikerült elküldeni.', 'error' => $e->getMessage()], 500);
        }
    }
}
