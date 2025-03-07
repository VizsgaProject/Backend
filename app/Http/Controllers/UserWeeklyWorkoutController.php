<?php

namespace App\Http\Controllers;

use App\Models\UserWeeklyWorkout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserWeeklyWorkoutController extends BaseController
{
    //Get User Weekly Workout
    public function index()
    {
        // Get the user weekly workout records of the authenticated user
        $userWeeklyWorkouts = UserWeeklyWorkout::where('user_id', Auth::id())->get();
        return $this->sendResponse($userWeeklyWorkouts, 'Adatok elküldve');
    }

    //Post User Weekly Workout
    public function store(Request $request)
    {

        $user = Auth::user();

        // Define and validate the input data
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'workouts_id' => 'required|exists:workouts,id',
                'dayOfWeek' => 'required|in:Hétfő,Kedd,Szerda,Csütörtök,Péntek,Szombat,Vasárnap',
                'reps' => 'required|numeric',
                'sets' => 'required|numeric',
                'date' => 'required|date',
            ],
            [
                'workouts_id.required' => 'A gyakorlat azonosítója kötelező.',
                'workouts_id.exists' => 'A megadott gyakorlat azonosító nem létezik.',
                'dayOfWeek.required' => 'A nap megadása kötelező.',
                'dayOfWeek.in' => 'A napnak a következők egyikének kell lennie: Hétfő, Kedd, Szerda, Csütörtök, Péntek, Szombat, Vasárnap.',
                'reps.required' => 'Az ismétlések száma kötelező.',
                'reps.numeric' => 'Az ismétlések számának numerikusnak kell lennie.',
                'sets.required' => 'A szettek száma kötelező.',
                'sets.numeric' => 'A szettek számának numerikusnak kell lennie.',
                'date.required' => 'A dátum megadása kötelező.',
                'date.date' => 'A dátum formátuma érvénytelen.',
            ]
        );

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

    //Update User Weekly Workout
    public function update(Request $request, $id)
    {
        //The logged in user's user weekly workout record
        $userWeeklyWorkout = UserWeeklyWorkout::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Define and validate the input data
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'workouts_id' => 'nullable|exists:workouts,id',
                'dayOfWeek' => 'nullable|in:Hétfő,Kedd,Szerda,Csütörtök,Péntek,Szombat,Vasárnap',
                'reps' => 'nullable|numeric',
                'sets' => 'nullable|numeric',
                'date' => 'nullable|date',
            ],
            [
                'workouts_id.exists' => 'A megadott gyakorlat azonosító nem létezik.',
                'dayOfWeek.in' => 'A napnak a következők egyikének kell lennie: Hétfő, Kedd, Szerda, Csütörtök, Péntek, Szombat, Vasárnap.',
                'reps.numeric' => 'Az ismétlések számának numerikusnak kell lennie.',
                'sets.numeric' => 'A szettek számának numerikusnak kell lennie.',
                'date.date' => 'A dátum formátuma érvénytelen.',
            ]
        );

        // If validation fails, return the error response
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), [], 400);
        }

        // Update the user weekly workout record
        $userWeeklyWorkout->update($input);

        return $this->sendResponse($userWeeklyWorkout, 'Adatok sikeresen frissítve!');
    }
    //Delete User Weekly Workout
    public function destroy($id)
    {
        //The logged in user's user weekly workout record
        $userWeeklyWorkout = UserWeeklyWorkout::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Delete the user weekly workout record
        $userWeeklyWorkout->delete();

        return $this->sendResponse([], 'Adatok sikeresen törölve!');
    }
}
