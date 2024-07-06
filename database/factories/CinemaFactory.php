<?php

namespace Database\Factories;

use App\Models\Cinema;
use App\Models\Distributor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cinema>
 */
class CinemaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Cinema::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'city_name' => $this->faker->city,
            'country_id' => $this->faker->numberBetween(1, 195),
            'unique_hash' => $this->faker->uuid,
            'visible_to_all' => $this->faker->boolean,
            'distributor_id' => \App\Models\Distributor::factory(),
            'password' => $this->faker->password,
            'downloaded_player' => $this->faker->boolean ? $this->faker->dateTimeThisYear : null,
            'created_at' => $this->faker->dateTimeThisYear,
            'updated_at' => now(),
        ];
    }
}
