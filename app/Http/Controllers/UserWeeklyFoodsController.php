<?php

namespace App\Http\Controllers;

use App\Models\UserWeeklyFood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserWeeklyFoodsController extends BaseController
{
    //Get User Weekly Food
    public function index()
    {
        $user = Auth::user();

        // Get the user weekly food records of the authenticated user
        $userWeeklyFoods = UserWeeklyFood::where('user_id', $user->id)->get();
        return $this->sendResponse($userWeeklyFoods, 'Adatok sikeresen lekérve!');
    }

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
            'dailyCalorieTarget' => [
                Rule::requiredIf(function () use ($input) {
                    // Check if data already exists for the date
                    return !UserWeeklyFood::where('date', $input['date'])->exists();
                }),
                'numeric',
            ],
            'dailyProteinTarget' => [
                Rule::requiredIf(function () use ($input) {
                    // Check if data already exists for the date
                    return !UserWeeklyFood::where('date', $input['date'])->exists();
                }),
                'numeric',
            ],
        ], [
            'foods_id.required' => 'Az étel azonosítója kötelező.',
            'foods_id.exists' => 'A megadott étel azonosító nem létezik.',
            'date.required' => 'A dátum megadása kötelező.',
            'date.date' => 'A dátum formátuma érvénytelen.',
            'dayOfWeek.required' => 'A nap megadása kötelező.',
            'dayOfWeek.in' => 'A napnak a következők egyikének kell lennie: Hétfő, Kedd, Szerda, Csütörtök, Péntek, Szombat, Vasárnap.',
            'mealType.required' => 'Az étkezés típusának megadása kötelező.',
            'mealType.in' => 'Az étkezés típusának a következők egyikének kell lennie: Reggeli, Ebéd, Vacsora, Nasi.',
            'time.required' => 'Az idő megadása kötelező.',
            'time.date_format' => 'Az idő formátuma érvénytelen. Az elfogadott formátum: Óó:pp.',
            'quantity.required' => 'A mennyiség megadása kötelező.',
            'quantity.numeric' => 'A mennyiségnek numerikusnak kell lennie.',
            'dailyCalorieTarget.numeric' => 'A napi kalória cél numerikusnak kell lennie.',
            'dailyProteinTarget.numeric' => 'A napi fehérje cél numerikusnak kell lennie.',
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
        $validator = Validator::make(
            $input,
            [
                'foods_id' => 'nullable|exists:foods,id',
                'date' => 'nullable|date',
                'dayOfWeek' => 'nullable|in:Hétfő,Kedd,Szerda,Csütörtök,Péntek,Szombat,Vasárnap',
                'mealType' => 'nullable|in:Reggeli,Ebéd,Vacsora,Nasi',
                'time' => 'nullable|date_format:H:i',
                'quantity' => 'nullable|numeric',
                'dailyCalorieTarget' => 'nullable|numeric',
                'dailyProteinTarget' => 'nullable|numeric',
            ],
            [
                'foods_id.exists' => 'A megadott étel azonosító nem létezik.',
                'date.date' => 'A dátum formátuma érvénytelen.',
                'dayOfWeek.in' => 'A napnak a következők egyikének kell lennie: Hétfő, Kedd, Szerda, Csütörtök, Péntek, Szombat, Vasárnap.',
                'mealType.in' => 'Az étkezés típusának a következők egyikének kell lennie: Reggeli, Ebéd, Vacsora, Nasi.',
                'time.date_format' => 'Az idő formátuma érvénytelen. Az elfogadott formátum: Óó:pp.',
                'quantity.numeric' => 'A mennyiségnek numerikusnak kell lennie.',
                'dailyCalorieTarget.numeric' => 'A napi kalória cél numerikusnak kell lennie.',
                'dailyProteinTarget.numeric' => 'A napi fehérje cél numerikusnak kell lennie.',
            ]
        );

        // If validation fails, return the error response
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), [], 400);
        }

        // Update only the fields provided in the request
        $userWeeklyFood->update($request->only(['foods_id', 'date', 'dayOfWeek', 'mealType', 'time', 'quantity', 'dailyCalorieTarget', 'dailyProteinTarget']));
        return $this->sendResponse($userWeeklyFood, 'Adatok sikeresen frissítve!');
    }

    //Delete User Weekly Food
    public function destroy($id)
    {
        $user = Auth::user();

        //The logged in user's user weekly food record
        $userWeeklyFood = UserWeeklyFood::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        // Delete the user weekly food record
        $userWeeklyFood->delete();
        return $this->sendResponse([], 'Adatok sikeresen törölve!');
    }
}
