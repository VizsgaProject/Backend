<?php
use Illuminate\Foundation\Testing\RefreshDatabase;

test('user cannot register with duplicate email or name', function () {
    // Létrehozzuk az első felhasználót
    $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password123',
        'confirm_password' => 'Password123',
        'dateOfBirth' => '2000-01-01',
        'gender' => 'Férfi',
    ])->assertStatus(201); // Sikeres regisztráció

    // Második felhasználó ugyanazzal az e-mail címmel és névvel
    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password1234',
        'confirm_password' => 'Password1234',
        'dateOfBirth' => '1999-01-01',
        'gender' => 'Nő',
    ]);

    // Ellenőrizzük, hogy hibát jelez, például 400-as státuszkódot
    $response->assertStatus(400);
    $response->assertJson([
        'success' => false,
        'message' => 'Hibás adatok!',
        'data' => [
            'name' => ["A felhasználónév már létezik!"],
            'email' => ["Email cím már létezik!"],
        ],
    ]);
})->uses(RefreshDatabase::class);
