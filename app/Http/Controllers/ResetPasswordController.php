<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/|min:8|max:30',
                'token' => 'required'
            ]
        );

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'A jelszó sikeresen vissza lett állítva.'], 200);
        }

        return response()->json(['error' => 'Hiba történt a jelszó visszaállítása során.'], 400);
    }
}
