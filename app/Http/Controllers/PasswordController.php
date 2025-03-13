<?php

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    // Az email küldését végző metódus
    public function resetpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Küldés a jelszó visszaállításhoz
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Visszajelzés az email sikeres küldéséről
        return $status == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Link sent!'], 200)
            : response()->json(['message' => 'Error sending reset link.'], 400);
    }
}
