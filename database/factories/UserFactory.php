<?php

namespace Database\Factories;

use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {




        return [
            'uuid' => fake()->uuid(),
            'username' => fake()->userName(),
            'password' => "12345678", // password
            'email' => fake()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'name' => fake()->name(),
            'birth_date' => fake()->date('Y-m-d', '2008-01-01'),
            'gender' => fake()->numberBetween(0, 2),
            'address' => fake()->streetAddress(),
            'reward_points' => fake()->randomNumber(4, false),
            'email_verified_at' => Carbon::now()->format('Y-m-d h:i:s'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
