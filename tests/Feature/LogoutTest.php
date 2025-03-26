<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can logout successfully', function () {
    // 1. Create a user using the UserFactory
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('Password123'), // Password is encrypted
        'dateOfBirth' => '2000-01-01',
        'gender' => 'Male',
    ]);

    // 2. Log in with the created user
    $loginResponse = $this->postJson('/api/login', [
        'name' => 'Test User', // The user's name
        'password' => 'Password123', // The user's password
    ]);

    // Verify that the login was successful
    $loginResponse->assertStatus(200); // HTTP 200 OK
    $loginResponse->assertJsonStructure([
        'data' => ['name', 'token', 'id'], // Verify the response fields
    ]);

    // Extract the token from the login response
    $loginToken = $loginResponse->json('data.token');

    // 3. Send a logout request with the token
    $logoutResponse = $this->withHeader('Authorization', "Bearer {$loginToken}")
        ->postJson('/api/logout');

    // Verify that the logout was successful
    $logoutResponse->assertStatus(200); // HTTP 200 OK
    $logoutResponse->assertJson([
        'message' => 'Sikeres kijelentkezés',
    ]);

    // Verify that the token no longer exists in the database
    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $loginResponse->json('data.id'),
        'tokenable_type' => User::class,
    ]);
});
