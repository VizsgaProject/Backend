<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can logout successfully', function () {
    // 1. Létrehozunk egy felhasználót a UserFactory segítségével
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('Password123'), // Jelszó titkosítva
        'dateOfBirth' => '2000-01-01',
        'gender' => 'Férfi',
    ]);

    // 2. Bejelentkezés a felhasználóval
    $loginResponse = $this->postJson('/api/login', [
        'name' => 'Test User', // A felhasználó neve
        'password' => 'Password123', // A felhasználó jelszava
    ]);

    // Ellenőrizzük, hogy sikeres a bejelentkezés
    $loginResponse->assertStatus(200); // HTTP 200 OK
    $loginResponse->assertJsonStructure([
        'data' => ['name', 'token', 'id'], // Ellenőrizzük a válasz mezőit
    ]);

    // Kinyerjük a tokent a bejelentkezési válaszból
    $loginToken = $loginResponse->json('data.token');

    // 3. Kijelentkezési kérés küldése a tokennel
    $logoutResponse = $this->withHeader('Authorization', "Bearer {$loginToken}")
        ->postJson('/api/logout');

    // Ellenőrizzük, hogy sikeres a kijelentkezés
    $logoutResponse->assertStatus(200); // HTTP 200 OK
    $logoutResponse->assertJson([
        'message' => 'Sikeres kijelentkezés',
    ]);

    // Ellenőrizzük, hogy a token már nem szerepel az adatbázisban
    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $loginResponse->json('data.id'),
        'tokenable_type' => User::class,
    ]);
});
