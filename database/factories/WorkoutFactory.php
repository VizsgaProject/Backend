<?php

namespace Database\Factories;

use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'muscleGroup' => $this->faker->randomElement(['Chest', 'Back', 'Legs', 'Arms', 'Shoulders', 'Abs']), // Random muscle group
            'name' => $this->faker->word, // Random name
            'img' => $this->faker->imageUrl(), // Random image URL
            'description' => $this->faker->sentence, // Random description
            'equipment' => $this->faker->word, // Random equipment
        ];
    }
}
