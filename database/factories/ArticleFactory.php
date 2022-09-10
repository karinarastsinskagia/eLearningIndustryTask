<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\Comment;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'title' => $this->faker->title,
            'content' => $this->faker->text,
            'category' => $this->faker->randomElement(['General', 'World','Nature']),
        ];
        
    }
}
