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
            'phone' => fake('ar_EG')->phoneNumber,
            'email' => $this->faker->unique()->email,
            'password' => 123,
            'latitude' => $this->faker->numberBetween(-90,90),
            'longitude' => $this->faker->numberBetween(-180,180),
            'is_active' => $this->faker->numberBetween(0,1)
        ];
    }
}
