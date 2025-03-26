<?php

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

test('user can retrieve their info via API', function () {
    // Create a user
    $user = User::factory()->create();

    // Create user info
    $userInfo = UserInfo::factory()->create([
        'user_id' => $user->id,
        'height' => 175,
        'weight' => 70,
    ]);

    // Log in and get the token
    $loginResponse = $this->postJson('/api/login', [
        'name' => $user->name,
        'password' => 'password', // Default password in the factory
    ]);

    $token = $loginResponse->json('data.token');

    // Retrieve user info
    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/user-info');

    // Verify the response is successful
    $response->assertStatus(200);
    $response->assertJson([
        'data' => [
            'height' => 175,
            'weight' => 70,
        ],
    ]);
});

test('user can store their info via API', function () {
    // Create a user
    $user = User::factory()->create();

    // Log in and get the token
    $loginResponse = $this->postJson('/api/login', [
        'name' => $user->name,
        'password' => 'password', // Default password in the factory
    ]);

    $token = $loginResponse->json('data.token');

    // Store user info
    $storeResponse = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson('/api/user-info', [
            'height' => 175,
            'weight' => 70,
        ]);

    // Verify the data is successfully stored
    $storeResponse->assertStatus(201); // HTTP 201 Created
    $storeResponse->assertJson([
        'message' => 'Adatok sikeresen elküldve!',
    ]);

    // Verify the data is saved in the database
    $this->assertDatabaseHas('userInfo', [
        'user_id' => $user->id,
        'height' => 175,
        'weight' => 70,
    ]);
});

test('user can update their info via API', function () {
    // Create a user
    $user = User::factory()->create();

    // Create user info
    $userInfo = UserInfo::factory()->create([
        'user_id' => $user->id,
        'height' => 175,
        'weight' => 70,
    ]);

    // Log in and get the token
    $loginResponse = $this->postJson('/api/login', [
        'name' => $user->name,
        'password' => 'password', // Default password in the factory
    ]);

    $token = $loginResponse->json('data.token');

    // Update user info
    $updateResponse = $this->withHeader('Authorization', "Bearer {$token}")
        ->putJson('/api/user-info', [
            'height' => 180,
            'weight' => 75,
        ]);

    // Verify the data is successfully updated
    $updateResponse->assertStatus(200); // HTTP 200 OK
    $updateResponse->assertJson([
        'message' => 'Adatok sikeresen frissítve!',
    ]);

    // Verify the data is updated in the database
    $this->assertDatabaseHas('userInfo', [
        'user_id' => $user->id,
        'height' => 180,
        'weight' => 75,
    ]);
});
