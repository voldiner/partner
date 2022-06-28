<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->realText(rand(15,150)),
            'user_id' => $this->faker->randomNumber(2, false),
            'administrator_id' => $this->faker->numberBetween(1,4),
            'created_at' => $this->faker->dateTimeBetween('-1 week', '-1 day')
        ];
    }
}
