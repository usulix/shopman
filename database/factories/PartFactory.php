<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Part;

class PartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Part::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->word(),
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(),
            'received' => $this->faker->boolean(),
        ];
    }
}
