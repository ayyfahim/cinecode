<?php

namespace Database\Factories;

use App\Models\Distributor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Distributor>
 */
class DistributorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Distributor::class;

    public function definition()
    {
        return [
            'distributor_name' => $this->faker->company,
            'allow_credit' => $this->faker->boolean,
            'credits' => $this->faker->numberBetween(1000, 10000),
            'password' => Hash::make('password'),
            'created_at' => $this->faker->dateTimeThisYear,
            'updated_at' => now(),
        ];
    }
}
