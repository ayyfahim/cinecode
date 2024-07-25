<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    protected $model = \App\Models\Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            // 'description' => $this->faker->text(),
            'poster_image' => $this->faker->imageUrl(400, 600, 'movies'),
            'cinema_visibility' => $this->faker->boolean,
            'release_date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
