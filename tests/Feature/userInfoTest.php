<?php

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

test('user can retrieve their info via API', function () {
    // Felhasználó létrehozása
    $user = User::factory()->create();

    // Felhasználói adatok létrehozása
    $userInfo = UserInfo::factory()->create([
        'user_id' => $user->id,
        'height' => 175,
        'weight' => 70,
    ]);

    // Bejelentkezés és token lekérése
    $loginResponse = $this->postJson('/api/login', [
        'name' => $user->name,
        'password' => 'password', // Alapértelmezett jelszó a factory-ban
    ]);

    $token = $loginResponse->json('data.token');

    // Felhasználói adatok lekérése
    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/user-info');

    // Ellenőrizzük, hogy sikeres a válasz
    $response->assertStatus(200);
    $response->assertJson([
        'data' => [
            'height' => 175,
            'weight' => 70,
        ],
    ]);
});

test('user can store their info via API', function () {
    // Felhasználó létrehozása
    $user = User::factory()->create();

    // Bejelentkezés és token lekérése
    $loginResponse = $this->postJson('/api/login', [
        'name' => $user->name,
        'password' => 'password', // Alapértelmezett jelszó a factory-ban
    ]);

    $token = $loginResponse->json('data.token');

    // Felhasználói adatok mentése
    $storeResponse = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson('/api/user-info', [
            'height' => 175,
            'weight' => 70,
        ]);

    // Ellenőrizzük, hogy sikeres a mentés
    $storeResponse->assertStatus(201); // HTTP 201 Created
    $storeResponse->assertJson([
        'message' => 'Adatok sikeresen elküldve!',
    ]);

    // Ellenőrizzük, hogy az adatok elmentődtek az adatbázisba
    $this->assertDatabaseHas('userInfo', [
        'user_id' => $user->id,
        'height' => 175,
        'weight' => 70,
    ]);
});

test('user can update their info via API', function () {
    // Felhasználó létrehozása
    $user = User::factory()->create();

    // Felhasználói adatok létrehozása
    $userInfo = UserInfo::factory()->create([
        'user_id' => $user->id,
        'height' => 175,
        'weight' => 70,
    ]);

    // Bejelentkezés és token lekérése
    $loginResponse = $this->postJson('/api/login', [
        'name' => $user->name,
        'password' => 'password', // Alapértelmezett jelszó a factory-ban
    ]);

    $token = $loginResponse->json('data.token');

    // Felhasználói adatok frissítése
    $updateResponse = $this->withHeader('Authorization', "Bearer {$token}")
        ->putJson('/api/user-info', [
            'height' => 180,
            'weight' => 75,
        ]);

    // Ellenőrizzük, hogy sikeres a frissítés
    $updateResponse->assertStatus(200); // HTTP 200 OK
    $updateResponse->assertJson([
        'message' => 'Adatok sikeresen frissítve!',
    ]);

    // Ellenőrizzük, hogy az adatok frissültek az adatbázisban
    $this->assertDatabaseHas('userInfo', [
        'user_id' => $user->id,
        'height' => 180,
        'weight' => 75,
    ]);
});
