<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'mid_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => '01023210100',
            'email' => $this->faker->unique()->email,
            'password' => 123456,
            'latitude' => rand(-90, 90),
            'longitude' => rand(-180,180),
            'is_active' => rand(0,1)
        ];
    }
}
