<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovieDistributor>
 */
class MovieDistributorFactory extends Factory
{
    protected $model = \App\Models\MovieDistributor::class;

    public function definition()
    {
        return [
            'movie_id' => \App\Models\Movie::factory(),
            'distributor_id' => \App\Models\Distributor::factory(),
        ];
    }
}
