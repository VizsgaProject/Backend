<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Models\Foods;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $genders = ['Férfi', 'Nő'];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:App\Models\User,name',
                'email' => 'required|email|unique:App\Models\User,email',
                'password' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/|min:8|max:30',
                'confirm_password' => 'required|same:password',
                'dateOfBirth' => 'required|date_format:Y-m-d',
                'gender' => 'required|in:' . implode(',', $genders),
            ],
            [
                'name.required' => "Kötelező kitölteni!",
                'name.unique' => "A felhasználónév már létezik!",
                'email.required' => "Kötelező kitölteni!",
                'email.email' => "Hibás email cím!",
                'email.unique' => "Email cím már létezik!",
                'password.required' => "Kötelező kitölteni!",
                'password.regex' => "A jelszónak tartalmaznia kell legalább egy kisbetűt, egy nagybetűt, egy számot!",
                'password.min' => "A jelszó legalább 8 karakter hosszúnak kell lennie!",
                'password.max' => "A jelszó legfeljebb 30 karakter lehet",
                'confirm_password.required' => "Kötelező kitölteni!",
                'confirm_password.same' => "A jelszavak nem egyeznek!",
                'dateOfBirth.required' => "Kötelező kitölteni!",
                'gender.required' => "Kötelező kitölteni!",
            ]
        );

        if ($validator->fails()) {
            logger($validator->errors());
            return $this->sendError('Hibás adatok!', $validator->errors(), 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        Mail::to($user->email)->send(new WelcomeEmail($user));

        $response = [
            'name' => $user->name,
            'token' => $user->createToken('Secret')->plainTextToken
        ];

        return $this->sendResponse($response, 'Sikeres regisztráció', 201);
    }

    public function login(Request $request)
    {
        if (Auth::attempt([
            'name' => $request->name,
            'password' => $request->password
        ])) {
            // succesful login
            $user = Auth::user();
            $response = [
                'name' => $user->name,
                'token' => $user->createToken('Secret')->plainTextToken,
                'id' => $user->id,
            ];
            return $this->sendResponse($response, 'Sikeres bejelentkezés', 200);
        } else {
            //faild to login
            return $this->sendError('', ['error' => 'Sikertelen bejelentkezés!'], 401);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->sendResponse('', 'Sikeres kijelentkezés');
    }
}
