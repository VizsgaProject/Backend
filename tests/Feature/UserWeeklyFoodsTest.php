<?php

use App\Models\User;
use App\Models\UserWeeklyFood;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

test('user can retrieve their weekly foods', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user via Sanctum
    Sanctum::actingAs($user);

    // Create weekly foods for the user
    $weeklyFoods = UserWeeklyFood::factory()->count(3)->create([
        'user_id' => $user->id,
    ]);

    // Retrieve weekly foods
    $response = $this->getJson('/api/user-weekly-foods');

    // Assert the response status and the number of returned weekly foods
    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
});

test('user can store a new weekly food', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user via Sanctum
    Sanctum::actingAs($user);

    // Define food data for storing
    $foodData = [
        'foods_id' => 1,
        'date' => '2025-03-23',
        'dayOfWeek' => 'Hétfő',
        'mealType' => 'Reggeli',
        'time' => '08:00',
        'quantity' => 200,
        'dailyCalorieTarget' => 2500,
        'dailyProteinTarget' => 120,
    ];

    // Send POST request to store the weekly food
    $response = $this->postJson('/api/user-weekly-foods', $foodData);

    // Assert that the response is correct
    $response->assertStatus(201);
    $response->assertJsonFragment($foodData);
});

test('user can update a weekly food', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user via Sanctum
    Sanctum::actingAs($user);

    // Create a weekly food for the user
    $userWeeklyFood = UserWeeklyFood::factory()->create([
        'user_id' => $user->id,
    ]);

    // Define updated food data
    $updatedFoodData = [
        'foods_id' => 2, // változtassuk meg a helyes mezőt, amit 'foods_id'
        'date' => '2025-03-24',
        'dayOfWeek' => 'Kedd',
        'mealType' => 'Ebéd',
        'time' => '12:00',
        'quantity' => 250,
        'dailyCalorieTarget' => 2500,
        'dailyProteinTarget' => 150,
    ];

    // Send PUT request to update the weekly food
    $response = $this->putJson("/api/user-weekly-foods/{$userWeeklyFood->id}", $updatedFoodData);

    // Assert that the response is correct
    $response->assertStatus(200);
    $response->assertJsonFragment($updatedFoodData);
});

test('user can delete a weekly food', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user via Sanctum
    Sanctum::actingAs($user);

    // Create a weekly food for the user
    $userWeeklyFood = UserWeeklyFood::factory()->create([
        'user_id' => $user->id,
    ]);

    // Send DELETE request to delete the weekly food
    $response = $this->deleteJson("/api/user-weekly-foods/{$userWeeklyFood->id}");

    // Assert the response is correct
    $response->assertStatus(200);

    // Assert that the record is removed from the database
    $this->assertDatabaseMissing('user_weekly_foods', [
        'id' => $userWeeklyFood->id,
    ]);
});
