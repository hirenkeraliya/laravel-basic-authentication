<?php

namespace Database\Factories;

use App\Models\SecondUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SecondUser>
 */
class SecondUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail(),
            'mobile_number' => $this->faker->unique()->phoneNumber(),
            'password' => bcrypt(12345678),
            'status' => rand(0, 1),
        ];
    }
}
