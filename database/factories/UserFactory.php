<?php

namespace Database\Factories;

use App\Constants\UserRoles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(), // 70% chance of having last name
            'email' => $this->faker->unique()->safeEmail(),
            'phone_verified_at' => $this->faker->optional(60)->dateTimeThisYear(), // 60% chance of being verified
            'password' => bcrypt('password'), // default password for all seeded users
            'contact_number' => $this->faker->unique()->phoneNumber(), // 80% chance of having contact number
            'status' => $this->faker->boolean(80), // 80% chance of being active
            'role' => $this->faker->randomElement([1,2,3]),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that the user is active.
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => true,
            ];
        });
    }

    /**
     * Indicate that the user is inactive.
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => false,
            ];
        });
    }

    /**
     * Indicate that the user's phone is verified.
     */
    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'phone_verified_at' => now(),
            ];
        });
    }
}