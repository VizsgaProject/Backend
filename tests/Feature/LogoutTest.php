<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can logout successfully', function () {
    // 1. Register a new user
    $registrationResponse = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password123',
        'confirm_password' => 'Password123',
        'dateOfBirth' => '2000-01-01',
        'gender' => 'Férfi',
    ]);

    // Verify that registration is successful
    $registrationResponse->assertStatus(201); // HTTP 201 Created

    // Extract the token from the registration response
    $registrationToken = $registrationResponse->json('data.token');

    // 2. Log in with the registered user's credentials
    $loginResponse = $this->postJson('/api/login', [
        'name' => 'Test User', // The registered user's name
        'password' => 'Password123', // The registered user's password
    ]);

    // Verify that login is successful
    $loginResponse->assertStatus(200); // HTTP 200 OK
    $loginResponse->assertJsonStructure([
        'data' => ['name', 'token', 'id'], // Verify response structure contains these fields
    ]);

    // Extract the token from the login response
    $loginToken = $loginResponse->json('data.token');

    // 3. Send a logout request using the login token
    $logoutResponse = $this->withHeader('Authorization', "Bearer {$loginToken}")
        ->postJson('/api/logout');

    // Verify that logout is successful
    $logoutResponse->assertStatus(200); // HTTP 200 OK
    $logoutResponse->assertJson([
        'message' => 'Sikeres kijelentkezés',
    ]);

    // Verify that the token is no longer present in the database
    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $loginResponse->json('data.id'),
        'tokenable_type' => User::class,
    ]);
});
