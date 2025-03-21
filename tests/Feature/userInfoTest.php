<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

test('user can register, login, and manage their info via API', function () {
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
    $registrationResponse->assertStatus(201); // HTTP 201 Created
    $registrationResponse->assertJsonStructure([
        'data' => ['name', 'token'],
    ]);

    // Token a regisztrációs válaszból
    $token = $registrationResponse->json('data.token');

    // 2. Login API hívás
    $loginResponse = $this->postJson('/api/login', [
        'name' => 'Test User', // A regisztrált felhasználó neve
        'password' => 'Password123', // A regisztrált jelszó
    ]);

    // Ellenőrizzük, hogy sikeres a login
    $loginResponse->assertStatus(200); // HTTP 200 OK
    $loginResponse->assertJsonStructure([
        'data' => ['name', 'token', 'id'], // Ellenőrizzük a válasz mezőit
    ]);

    // Login token (előző token nem feltétlenül szükséges)
    $loginToken = $loginResponse->json('data.token');

    // 3. Felhasználói adatok mentése
    $storeResponse = $this->withHeader('Authorization', "Bearer {$loginToken}")
        ->postJson('/api/user-info', [
            'height' => 175,
            'weight' => 70,
        ]);

    $storeResponse->assertStatus(201); // HTTP 201 Created
    $storeResponse->assertJson([
        'message' => 'Adatok sikeresen elküldve!',
    ]);

    // Assert Initial Values After Creation
    $this->assertDatabaseHas('userInfo', [
        'user_id' => $loginResponse->json('data.id'), // Match table name from migration
        'height' => 175,
        'weight' => 70,
    ]);

    // 4. Felhasználói adatok frissítése
    $updateResponse = $this->withHeader('Authorization', "Bearer {$loginToken}")
        ->putJson('/api/user-info', [
            'height' => 180,
            'weight' => 75,
        ]);

    $updateResponse->assertStatus(200); // HTTP 200 OK
    $updateResponse->assertJson([
        'message' => 'Adatok sikeresen frissítve!',
    ]);

    // Assert Updated Values After Update
    $this->assertDatabaseHas('userInfo', [
        'user_id' => $loginResponse->json('data.id'), // Match table name from migration
        'height' => 180,
        'weight' => 75,
    ]);
});
