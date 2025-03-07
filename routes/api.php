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
    Route::post('user-info', [UserInfoController::class]); //post
    Route::get('user-info', [UserInfoController::class, 'index']); //get
    Route::put('user-info', [UserInfoController::class, 'update']); //update

    //user-weekly-foods
    Route::resource('user-weekly-foods', UserWeeklyFoodsController::class); //post
    Route::get('user-weekly-foods', [UserWeeklyFoodsController::class, 'index']); //get all
    Route::put('user-weekly-foods/{id}', [UserWeeklyFoodsController::class, 'update']); //update
    Route::delete('user-weekly-foods/{id}', [UserWeeklyFoodsController::class, 'destroy']); //delete

    //user-weekly-workouts
    Route::resource('user-weekly-workouts', UserWeeklyWorkoutController::class); //post
    Route::get('user-weekly-workouts', [UserWeeklyWorkoutController::class, 'index']); //get all
    Route::put('user-weekly-workouts/{id}', [UserWeeklyWorkoutController::class, 'update']); //update
    Route::delete('user-weekly-workouts/{id}', [UserWeeklyWorkoutController::class, 'destroy']); //delete
});
