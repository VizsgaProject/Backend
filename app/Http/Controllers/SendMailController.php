<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Resetpassword;
use App\Models\User;

class SendMailController extends Controller
{
    public function sendMail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $mailData = [
                'name' => $user->name,
            ];

            try {
                Mail::to($request->email)->send(new Resetpassword($mailData));
                return response()->json(['message' => 'Az email sikeresen elküldve.'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Az emailt nem sikerült elküldeni.', 'error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Az email cím nem található.'], 404);
        }
    }
}
