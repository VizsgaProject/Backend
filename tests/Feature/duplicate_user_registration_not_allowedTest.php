<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

test('user cannot register with duplicate email or name', function () {
    // Clean the database before each test
    uses(RefreshDatabase::class);

    // Create a user using the UserFactory
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('Password123'),
        'dateOfBirth' => '2000-01-01',
        'gender' => 'Férfi',
    ]);

    // Create a second user with the same email and name
    $response = $this->postJson('/api/register', [
        'name' => 'Test User', // Ugyanaz a név
        'email' => 'test@example.com', // Ugyanaz az e-mail cím
        'password' => 'Password1234',
        'confirm_password' => 'Password1234',
        'dateOfBirth' => '1999-01-01',
        'gender' => 'Nő',
    ]);

    // Verify that an error is thrown, such as a 400 status code
    $response->assertStatus(400);
    $response->assertJson([
        'success' => false,
        'message' => 'Hibás adatok!',
        'data' => [
            'name' => ["A felhasználónév már létezik!"],
            'email' => ["Email cím már létezik!"],
        ],
    ]);
});
