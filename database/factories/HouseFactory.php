<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class HouseFactory extends Factory
{
    public function definition()
    {
        $owners = User::where('role', USER_ROLE_OWNER)->get();
        if ($owners->isEmpty()) {
            $owners = User::factory()->count(3)->owner()->create();
        }

        // Then ensure tenants exist
        $tenants = User::where('role', USER_ROLE_TENANT)->get();
        if ($tenants->isEmpty()) {
            $tenants = User::factory()->count(5)->tenant()->create();
        }
        return [
            'name' => $this->faker->word . ' ' . $this->faker->randomElement(['Villa', 'Apartment', 'House', 'Condo', 'Studio']),
            'price' => $this->faker->randomFloat(2, 500, 10000),
            'payment_date' => $this->faker->optional()->dateTimeBetween('-1 year', '+1 year'),
            'address' => $this->faker->address,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'description' => $this->faker->paragraphs(3, true),
            'review' => $this->faker->randomFloat(1, 0, 5),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'owner_id' => $owners->random()->id,
            'tenant_id' => $this->faker->optional(0.5)->randomElement($tenants->pluck('id')->toArray()),
        ];
    }
}