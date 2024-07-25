<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovieVersion>
 */
class MovieVersionFactory extends Factory
{
    protected $model = \App\Models\MovieVersion::class;

    public function definition()
    {
        return [
            'version_name' => $this->faker->word,
            'video_link' => $this->faker->url,
            'mcck_file' => $this->faker->filePath(),
            'movie_id' => \App\Models\Movie::factory(),
        ];
    }
}
