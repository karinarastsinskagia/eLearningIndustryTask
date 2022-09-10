<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\Comment;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            
        return [
            'owner' => $this->faker->name,
            'content' => $this->faker->text,
            'article_id' => Article::factory(),
           
        ];
        
    }
}
