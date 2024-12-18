<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\LineItem;

class LineItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LineItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'price' => $this->faker->randomNumber(),
            'invoice_id' => Invoice::factory(),
        ];
    }
}
