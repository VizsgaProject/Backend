<?php

namespace Database\Factories;

use App\Models\Foods;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    protected $model = Foods::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Véletlenszerű ételnév
            'img' => $this->faker->imageUrl(), // Véletlenszerű kép URL
            'weight' => $this->faker->numberBetween(50, 500), // Véletlenszerű súly (50-500 gramm)
            'calories' => $this->faker->numberBetween(50, 500), // Véletlenszerű kalória (50-500 kcal)
            'protein' => $this->faker->numberBetween(5, 50), // Véletlenszerű fehérje (5-50 g)
            'carbohydrate' => $this->faker->numberBetween(5, 100), // Véletlenszerű szénhidrát (5-100 g)
            'fat' => $this->faker->numberBetween(1, 30), // Véletlenszerű zsír (1-30 g)
            'type' => $this->faker->randomElement(['Fehérje', 'Szénhidrát', 'Zsír']), // Véletlenszerű típus
        ];
    }
}
