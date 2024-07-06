<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Cinema;
use App\Models\Distributor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;

    public function definition()
    {
        return [
            'distributor_id' => \App\Models\Distributor::factory(),
            'cinema_id' => \App\Models\Cinema::factory(),
            'movie_id' => $this->faker->numberBetween(1, 100), // Assuming you have movies with IDs from 1 to 100
            'downloaded' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeThisYear,
            'updated_at' => now(),
        ];
    }
}
