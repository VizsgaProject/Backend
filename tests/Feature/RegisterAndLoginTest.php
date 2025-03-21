<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

test('user can register and login via API', function () {
    // 1. Regisztráció API hívás
    $registrationResponse = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password123',
        'confirm_password' => 'Password123',
        'dateOfBirth' => '2000-01-01',
        'gender' => 'Férfi',
    ]);

    // Ellenőrizzük, hogy sikeres a regisztráció
    $registrationResponse->assertStatus(201); // 201 = Created

    // 2. Login API hívás
    $loginResponse = $this->postJson('/api/login', [
        'name' => 'Test User', // A regisztrált felhasználó neve
        'password' => 'Password123', // A regisztrált jelszó
    ]);

    // Ellenőrizzük, hogy sikeres a login
    $loginResponse->assertStatus(200); // 200 = OK
    $loginResponse->assertJsonStructure([
        'data' => ['name', 'token', 'id'], // Ellenőrizzük, hogy a válasz tartalmazza ezeket
    ]);
})->uses(RefreshDatabase::class);
