<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\UserWeeklyFoodsController;
use App\Http\Controllers\UserWeeklyWorkoutController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// api/
// Public routes (no authentication required)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Password Reset Routes
Route::post('password/reset', [ResetPasswordController::class, 'reset']);
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);


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
    Route::resource('user-weekly-foods', UserWeeklyFoodsController::class)->except(['create', 'edit']); // Automatically generates routes for index, store, update, destroy

    // Weekly Workouts Routes
    Route::resource('user-weekly-workouts', UserWeeklyWorkoutController::class)->except(['create', 'edit']); // Automatically generates routes for index, store, update, destroy
});
