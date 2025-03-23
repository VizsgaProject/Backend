<?php

namespace Database\Factories;

use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserInfoFactory extends Factory
{
    /**
     * A modell, amelyhez ez a factory tartozik.
     *
     * @var string
     */
    protected $model = UserInfo::class;

    /**
     * A modell alapértelmezett állapotának definiálása.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Hozd létre a User példányt is
            'height' => $this->faker->numberBetween(150, 200), // Véletlenszerű magasság
            'weight' => $this->faker->numberBetween(40, 120),  // Véletlenszerű súly
        ];
    }
}
