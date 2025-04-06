<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_first_name'       => fake()->firstName(),
            'user_last_name'        => fake()->lastName(),
            'user_email'            => fake()->unique()->safeEmail(),
            'user_password'         => static::$password ??= Hash::make('password'),
            'user_contact_no'       => fake()->phoneNumber(),
            'user_date_of_birth'    => fake()->date(),
            'user_type'             => 'customer',
            'user_account_status'   => 'active',
            'email_verified_at'     => now(),
            'remember_token'        => Str::random(10),
        ];
    }

    /**
     * Define a state for employees.
     */
    public function employee(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_type' => 'employee',
        ]);
    }

    /**
     * Define a state for customers.
     */
    public function customer(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_type' => 'customer',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
