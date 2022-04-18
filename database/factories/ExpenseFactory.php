<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-14 days', 'now'),
            'title' => $this->faker->sentence(6),
            'amount' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
