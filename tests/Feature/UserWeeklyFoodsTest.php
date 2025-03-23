<?php

use App\Models\User;
use App\Models\UserWeeklyFood;
use Illuminate\Foundation\Testing\RefreshDatabase;

test('user can retrieve their weekly foods', function () {
    // Felhasználó létrehozása
    $user = User::factory()->create();

    // Heti ételek létrehozása a felhasználóhoz
    $weeklyFoods = UserWeeklyFood::factory()->count(3)->create([
        'user_id' => $user->id,
    ]);

    // Bejelentkezés és token lekérése
    $loginResponse = $this->postJson('/api/login', [
        'name' => $user->name,
        'password' => 'password', // Alapértelmezett jelszó a factory-ban
    ]);

    $token = $loginResponse->json('data.token');

    // Heti ételek lekérése
    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/user-weekly-foods');

    // Ellenőrizzük, hogy sikeres a válasz
    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data'); // Ellenőrizzük, hogy 3 heti étel van
});
