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
        // Felhasználó adatainak keresése
        $userInfo = UserInfo::find($id);
        if (is_null($userInfo)) {
            return $this->sendError('Nem található ilyen adat!', [], 404);
        }

        // Bejövő adatok validálása
        $input = $request->all();
        $validator = Validator::make($input, [
            'height' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'weight' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Érvénytelen adatok.', $validator->errors()->all(), 400);
        }

        // Csak a megadott mezők frissítése
        if (isset($input['height'])) {
            $userInfo->height = $input['height'];
        }
        if (isset($input['weight'])) {
            $userInfo->weight = $input['weight'];
        }
        $userInfo->save();

        // Válasz küldése
        return $this->sendResponse($userInfo, 'Adatok sikeresen frissítve!');
    }
}
