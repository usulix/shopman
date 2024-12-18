<?php

namespace Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'email_verified' => $this->faker->dateTime(),
            'password' => Hash::make('password'),
            'isOwner' => $this->faker->boolean(),
            'remember_token' => $this->faker->uuid(),
        ];
    }
}
