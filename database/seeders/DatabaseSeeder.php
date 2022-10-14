<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        Category::factory(3)->create();

        User::factory()->has(Article::factory()->count(5))->count(2)->create();

    }
}
