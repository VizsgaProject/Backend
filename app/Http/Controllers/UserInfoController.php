<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends BaseController
{
    // Get the user's info
    public function index()
    {
        $user = Auth::user();
        $userInfo = UserInfo::where('user_id', $user->id)->first();
        return $this->sendResponse($userInfo, 'Adatok sikeresen lekérve!');
    }

    // Post the user's info
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'height' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:50|max:250',
                'weight' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:30|max:300',
            ],
            [
                'height.required' => 'A magasság megadása kötelező.',
                'height.regex' => 'A magasság formátuma érvénytelen. Példa: 170 vagy 170.5.',
                'height.min' => 'A magasság nem lehet kisebb, mint 50 cm.',
                'height.max' => 'A magasság nem lehet nagyobb, mint 250 cm.',
                'weight.required' => 'A súly megadása kötelező.',
                'weight.regex' => 'A súly formátuma érvénytelen. Példa: 70 vagy 70.25.',
                'weight.min' => 'A súly nem lehet kisebb, mint 30 kg.',
                'weight.max' => 'A súly nem lehet nagyobb, mint 300 kg.',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Érvénytelen adatok.', $validator->errors(), 400);
        }
        $input['user_id'] = $user->id;
        $userInfo = UserInfo::create($input);
        return $this->sendResponse($userInfo, 'Adatok sikeresen elküldve!', 201);
    }

    // Update the user's info
    public function update(Request $request)
    {
        // The logged in user's data is retrieved from the token
        $user = Auth::user();

        // The logged in user's info record
        $userInfo = UserInfo::where('user_id', $user->id)->firstOrFail();

        // Validate incoming data
        $validator = Validator::make(
            $request->all(),
            [
                'height' => 'nullable|regex:/^\d+(\.\d{1,2})?$/|min:50|max:250',
                'weight' => 'nullable|regex:/^\d+(\.\d{1,2})?$/|min:30|max:300',
            ],
            [
                'height.regex' => 'A magasság formátuma érvénytelen. Példa: 170 vagy 170.5.',
                'height.min' => 'A magasság nem lehet kisebb, mint 50 cm.',
                'height.max' => 'A magasság nem lehet nagyobb, mint 250 cm.',
                'weight.regex' => 'A súly formátuma érvénytelen. Példa: 70 vagy 70.25.',
                'weight.min' => 'A súly nem lehet kisebb, mint 30 kg.',
                'weight.max' => 'A súly nem lehet nagyobb, mint 300 kg.',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Érvénytelen adatok.', $validator->errors(), 400);
        }

        // Update only the fields provided in the request
        $userInfo->update($request->only(['height', 'weight']));

        // Send success response
        return $this->sendResponse($userInfo, 'Adatok sikeresen frissítve!');
    }
}
