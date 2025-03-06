<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends BaseController
{
    // Show current user's info
    public function index()
    {
        $userInfo = UserInfo::all();
        return $this->sendResponse($userInfo, 'Adatok elküldve');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [
            'height' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'weight' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), [], 400);
        }
        $input['user_id'] = $user->id;
        $userInfo = UserInfo::create($input);
        return $this->sendResponse($userInfo, 'Adatok sikeresen elküldve!', 201);
    }


    // Update the user's info
    public function update(Request $request, $id)
    {
        // Try to find the user's info or return a 404 if not found
        $userInfo = UserInfo::findOrFail($id);  // Automatically handles the 404

        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'height' => 'nullable|numeric|min:0',  // Ensure height is a number and positive if present
            'weight' => 'nullable|numeric|min:0',  // Ensure weight is a number and positive if present
        ]);

        if ($validator->fails()) {
            return $this->sendError('Érvénytelen adatok.', $validator->errors()->all(), 400);
        }

        // Only update the fields provided in the request
        if ($request->has('height')) {
            $userInfo->height = $request->input('height');
        }
        if ($request->has('weight')) {
            $userInfo->weight = $request->input('weight');
        }

        // Save updated user info
        $userInfo->save();

        // Send success response
        return $this->sendResponse($userInfo, 'Adatok sikeresen frissítve!');
    }
}
