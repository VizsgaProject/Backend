<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

test('user can register and login via API', function () {
    // 1. Registration API call
    $registrationResponse = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password123',
        'confirm_password' => 'Password123',
        'dateOfBirth' => '2000-01-01',
        'gender' => 'Férfi',
    ]);

    // Verify that the registration is successful
    $registrationResponse->assertStatus(201); // 201 = Created

    // 2. Login API call
    $loginResponse = $this->postJson('/api/login', [
        'name' => 'Test User', // The name of the registered user
        'password' => 'Password123', // The registered password
    ]);

    // Verify that the login is successful
    $loginResponse->assertStatus(200); // 200 = OK
    $loginResponse->assertJsonStructure([
        'data' => ['name', 'token', 'id'], // Verify that the response contains these fields
    ]);
})->uses(RefreshDatabase::class);
