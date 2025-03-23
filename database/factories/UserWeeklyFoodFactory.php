<?php

namespace Database\Factories;

use App\Models\UserWeeklyFood;
use App\Models\Foods;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserWeeklyFoodFactory extends Factory
{
    protected $model = UserWeeklyFood::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Kapcsolódó felhasználó
            'foods_id' => Foods::factory(), // Kapcsolódó étel (Foods modell használata)
            'date' => $this->faker->date,
            'dayOfWeek' => $this->faker->randomElement(['Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat', 'Vasárnap']),
            'mealType' => $this->faker->randomElement(['Reggeli', 'Ebéd', 'Vacsora', 'Nasi']),
            'time' => $this->faker->time('H:i'),
            'quantity' => $this->faker->numberBetween(50, 500),
            'dailyCalorieTarget' => $this->faker->numberBetween(1500, 3000),
            'dailyProteinTarget' => $this->faker->numberBetween(50, 200),
        ];
    }
}
