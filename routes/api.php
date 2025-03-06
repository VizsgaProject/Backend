<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\UserWeeklyFoodsController;
use App\Http\Controllers\UserWeeklyWorkoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// api/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('foods', [FoodController::class, 'foods']);
Route::get('foods/{type}', [FoodController::class, 'food']);

Route::get('workouts', [WorkoutController::class, 'workouts']);
Route::get('workouts/{musclegroup}', [WorkoutController::class, 'workout']);

Route::any('have-to-login', function () {
    // return response()->json('Bejelentkezés szükséges',401);
    $bc = new BaseController();
    return $bc->sendError('Bejelentkezés szükséges', '', 401);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    //user-info
    Route::resource('user-info',UserInfoController::class, ['execpt' => 'index']);
    Route::resource('user-info-update', UserInfoController::class, 'update');

    //user-weekly-foods
    Route::resource('user-weekly-foods', UserWeeklyFoodsController::class);

    //user-weekly-workouts
    Route::resource('user-weekly-workouts', UserWeeklyWorkoutController::class);
});

