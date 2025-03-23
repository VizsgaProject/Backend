<?php

use App\Models\User;
use App\Models\Workout;
use App\Models\UserWeeklyWorkout;
use Laravel\Sanctum\Sanctum;

// Test for retrieving all weekly workouts
test('it can retrieve all weekly workouts', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user via Sanctum
    Sanctum::actingAs($user);

    // Create weekly workouts for the user
    $weeklyWorkouts = UserWeeklyWorkout::factory()->count(3)->create([
        'user_id' => $user->id,
    ]);

    // Send GET request to retrieve weekly workouts
    $response = $this->getJson('/api/user-weekly-workouts');

    // Assert the response status and the number of returned weekly workouts
    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
});

// Test for storing a new weekly workout
test('it can store a new weekly workout', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user via Sanctum
    Sanctum::actingAs($user);

    // Create a workout for this user (if required)
    $workout = Workout::factory()->create();

    // Send a POST request to store a new weekly workout
    $response = $this->postJson('/api/user-weekly-workouts', [
        'workouts_id' => $workout->id,  // Workout ID
        'user_id' => $user->id,         // User ID (if required by backend logic)
        'dayOfWeek' => 'Hétfő',          // Valid day of the week
        'reps' => 10,                    // Valid number of reps
        'sets' => 3,                     // Valid number of sets
        'date' => '2023-10-01',          // Valid date (Y-m-d format)
    ]);

    // Assert the response status is 201 (Created)
    $response->assertStatus(201)
        ->assertJsonFragment([  // Use assertJsonFragment to check partial response data
            'workouts_id' => $workout->id,
            'user_id' => $user->id,
            'dayOfWeek' => 'Hétfő',
            'reps' => 10,
            'sets' => 3,
            'date' => '2023-10-01',
        ]);

    // Optionally, also check if the 'id' field is present in the response
    $response->assertJsonStructure([
        'success',
        'data' => [
            'id',
            'workouts_id',
            'user_id',
            'dayOfWeek',
            'reps',
            'sets',
            'date',
        ],
        'message',
    ]);
});

// Test for updating a weekly workout
test('it can update a weekly workout', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user via Sanctum
    Sanctum::actingAs($user);

    // Create a weekly workout for the user
    $userWeeklyWorkout = UserWeeklyWorkout::factory()->create([
        'user_id' => $user->id,
    ]);

    // Define updated workout data
    $updatedWorkoutData = [
        'workouts_id' => $userWeeklyWorkout->workouts_id, // Change to the appropriate field if necessary
        'dayOfWeek' => 'Kedd',
        'reps' => 12,
        'sets' => 4,
        'date' => '2023-10-02',
    ];

    // Send PUT request to update the weekly workout
    $response = $this->putJson("/api/user-weekly-workouts/{$userWeeklyWorkout->id}", $updatedWorkoutData);

    // Assert that the response is correct
    $response->assertStatus(200);
    $response->assertJsonFragment($updatedWorkoutData);
});

// Test for deleting a weekly workout
test('it can delete a weekly workout', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user via Sanctum
    Sanctum::actingAs($user);

    // Create a weekly workout for the user
    $userWeeklyWorkout = UserWeeklyWorkout::factory()->create([
        'user_id' => $user->id,
    ]);

    // Send DELETE request to delete the weekly workout
    $response = $this->deleteJson("/api/user-weekly-workouts/{$userWeeklyWorkout->id}");

    // Assert the response is correct
    $response->assertStatus(200);

    // Assert that the record is removed from the database
    $this->assertDatabaseMissing('user_weekly_workouts', [
        'id' => $userWeeklyWorkout->id,
    ]);
});
