<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends BaseController
{
    // Post the user's info
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [
            'height' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'weight' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
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
        $user = auth()->user();

        // The logged in user's info record
        $userInfo = UserInfo::where('user_id', $user->id)->firstOrFail();

        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'height' => 'nullable|numeric|min:0',  // Ensure height is a number and positive if present
            'weight' => 'nullable|numeric|min:0',  // Ensure weight is a number and positive if present
        ]);

        if ($validator->fails()) {
            return $this->sendError('Érvénytelen adatok.', $validator->errors(), 400);
        }

        // Update only the fields provided in the request
        $userInfo->update($request->only(['height', 'weight']));

        // Send success response
        return $this->sendResponse($userInfo, 'Adatok sikeresen frissítve!');
    }
}
