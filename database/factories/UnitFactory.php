<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Unit;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->randomNumber(),
            'make' => $this->faker->word(),
            'model' => $this->faker->word(),
            'mileage' => $this->faker->randomNumber(),
            'customer_id' => Customer::factory(),
        ];
    }
}
