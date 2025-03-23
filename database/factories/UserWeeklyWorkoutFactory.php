<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserWeeklyWorkoutFactory extends Factory
{
    /**
     * The name of the model the factory is for.
     *
     * @var string
     */
    protected $model = \App\Models\UserWeeklyWorkout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,  // Randomly get a user
            'workouts_id' => Workout::inRandomOrder()->first()->id,  // Use 'workouts_id' here
            'dayOfWeek' => $this->faker->randomElement(['Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat', 'Vasárnap']),
            'sets' => $this->faker->numberBetween(1, 5),  // Random number of sets
            'reps' => $this->faker->numberBetween(5, 20),  // Random number of reps
            'date' => $this->faker->date(),  // Random date
        ];
    }
}
