<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Customer;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->word(),
            'address2' => $this->faker->secondaryAddress(),
            'city' => $this->faker->city(),
            'region' => $this->faker->word(),
            'country' => $this->faker->country(),
            'postal_code' => $this->faker->postcode(),
            'account_id' => Account::factory(),
        ];
    }
}
