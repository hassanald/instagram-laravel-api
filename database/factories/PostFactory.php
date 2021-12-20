<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Post::class;


    public function definition()
    {
        return [
            'title' => $this->faker->text(20),
            'slug' => $this->faker->unique()->slug(),
            'caption' => $this->faker->paragraph(1),
            'user_id' => User::all()->random()->id
        ];
    }
}
