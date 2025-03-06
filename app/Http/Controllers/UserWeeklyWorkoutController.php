<?php

namespace App\Http\Controllers;

use App\Models\UserWeeklyWorkout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserWeeklyWorkoutController extends BaseController
{
    public function index()
    {
        $userWeeklyWorkouts = UserWeeklyWorkout::where('user_id', Auth::id())->get();
        return $this->sendResponse($userWeeklyWorkouts, 'Adatok elküldve');
    }

    public function store(Request $request)
    {

        $user = Auth::user();

        // Define and validate the input data
        $input = $request->all();
        $validator = Validator::make($input, [
            'workouts_id' => 'required|exists:workouts,id',
            'dayOfWeek' => 'required|in:Hétfő,Kedd,Szerda,Csütörtök,Péntek,Szombat,Vasárnap',
            'reps' => 'required|numeric',
            'sets' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), [], 400);
        }

        // Add the authenticated user ID to the input data
        $input['user_id'] = $user->id;

        // Create a new user weekly workout entry
        $userWeeklyWorkout = UserWeeklyWorkout::create($input);

        return $this->sendResponse($userWeeklyWorkout, 'Adatok sikeresen elküldve!', 201);
    }
}
