<?php

namespace App\Http\Controllers;

use App\Models\UserWeeklyFood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserWeeklyFoodsController extends BaseController
{
    //Post User Weekly Food
    public function store(Request $request)
    {
        $user = Auth::user();

        // Define and validate the input data
        $input = $request->all();
        $validator = Validator::make($input, [
            'foods_id' => 'required|exists:foods,id',
            'date' => 'required|date',
            'dayOfWeek' => 'required|in:Hétfő,Kedd,Szerda,Csütörtök,Péntek,Szombat,Vasárnap',
            'mealType' => 'required|in:Reggeli,Ebéd,Vacsora,Nasi',
            'time' => 'required|date_format:H:i',
            'quantity' => 'required|numeric',
            'dailyCalorieTarget' => 'required|numeric',
            'dailyProteinTarget' => 'required|numeric',
        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), [], 400);
        }

        // Add the authenticated user ID to the input data
        $input['user_id'] = $user->id;

        // Create a new user weekly food entry
        $userWeeklyFood = UserWeeklyFood::create($input);

        return $this->sendResponse($userWeeklyFood, 'Adatok sikeresen elküldve!', 201);
    }

    //Update User Weekly Food
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        //The logged in user's user weekly food record
        $userWeeklyFood = UserWeeklyFood::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        // Define and validate the input data
        $input = $request->all();
        $validator = Validator::make($input, [
            'foods_id' => 'nullable|exists:foods,id',
            'date' => 'nullable|date',
            'dayOfWeek' => 'nullable|in:Hétfő,Kedd,Szerda,Csütörtök,Péntek,Szombat,Vasárnap',
            'mealType' => 'nullable|in:Reggeli,Ebéd,Vacsora,Nasi',
            'time' => 'nullable|date_format:H:i',
            'quantity' => 'nullable|numeric',
            'dailyCalorieTarget' => 'nullable|numeric',
            'dailyProteinTarget' => 'nullable|numeric',
        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), [], 400);
        }

        // Update only the fields provided in the request
        $userWeeklyFood->update($request->only(['foods_id', 'date', 'dayOfWeek', 'mealType', 'time', 'quantity', 'dailyCalorieTarget', 'dailyProteinTarget']));
        return $this->sendResponse($userWeeklyFood, 'Adatok sikeresen frissítve!');

    }
}
