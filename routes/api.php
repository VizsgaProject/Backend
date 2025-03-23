<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\UserWeeklyFoodsController;
use App\Http\Controllers\UserWeeklyWorkoutController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SendMailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// api/
// Public routes (no authentication required)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//reset password
// Send reset password link
Route::get('reset-password', [SendMailController::class, 'sendMail']);

// Show reset password form
Route::get('reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('reset.password');

// Handle password update
Route::post('update-password', [PasswordController::class, 'updatePassword'])->name('update.password');

Route::get('foods', [FoodController::class, 'foods']);
Route::get('foods/{type}', [FoodController::class, 'food']);

Route::get('workouts', [WorkoutController::class, 'workouts']);
Route::get('workouts/{musclegroup}', [WorkoutController::class, 'workout']);

// Any route that doesn't require authentication can be caught here
Route::any('have-to-login', function () {
    return response()->json('Bejelentkezés szükséges', 401);
});

// Protected routes (require authentication via Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // User Info Routes
    Route::get('user-info', [UserInfoController::class, 'index']); // GET - retrieve user info
    Route::post('user-info', [UserInfoController::class, 'store']); // POST - store user info
    Route::put('user-info', [UserInfoController::class, 'update']); // PUT - update user info

    // Weekly Foods Routes
    Route::get('user-weekly-foods', [UserWeeklyFoodsController::class, 'index']); // GET - retrieve all weekly foods
    Route::post('user-weekly-foods', [UserWeeklyFoodsController::class, 'store']); // POST - store new weekly food
    Route::put('user-weekly-foods/{id}', [UserWeeklyFoodsController::class, 'update']); // PUT - update weekly food
    Route::delete('user-weekly-foods/{id}', [UserWeeklyFoodsController::class, 'destroy']); // DELETE - delete weekly food


    // Weekly Workouts Routes
    Route::get('user-weekly-workouts', [UserWeeklyWorkoutController::class, 'index']); // GET - retrieve all weekly workouts
    Route::post('user-weekly-workouts', [UserWeeklyWorkoutController::class, 'store']); // POST - store new weekly workout
    Route::put('user-weekly-workouts/{id}', [UserWeeklyWorkoutController::class, 'update']); // PUT - update weekly workout
    Route::delete('user-weekly-workouts/{id}', [UserWeeklyWorkoutController::class, 'destroy']); // DELETE - delete weekly workout

});
