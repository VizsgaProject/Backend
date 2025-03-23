<?php

namespace Database\Factories;

use App\Models\Foods;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodsFactory extends Factory
{
    protected $model = Foods::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'img' => $this->faker->imageUrl(),
            'weight' => $this->faker->numberBetween(100, 500),
            'calories' => $this->faker->randomFloat(1, 50, 500),
            'protein' => $this->faker->randomFloat(1, 0, 50),
            'carbohydrate' => $this->faker->randomFloat(1, 0, 50),
            'fat' => $this->faker->randomFloat(1, 0, 50),
            'type' => $this->faker->randomElement(['Fehérje', 'Szénhidrát', 'Zsír']),
        ];
    }
}
