<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->firstName().' '.$this->faker->unique()->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('11111111'),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(10),
        ];
    }
}
