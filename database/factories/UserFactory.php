<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name, // Véletlenszerű név
            'email' => $this->faker->unique()->safeEmail, // Véletlenszerű egyedi email
            'password' => Hash::make('password'), // Alapértelmezett jelszó: "password"
            'dateOfBirth' => $this->faker->date, // Véletlenszerű dátum
            'gender' => $this->faker->randomElement(['Férfi', 'Nő']), // Véletlenszerű nem
        ];
    }
}
