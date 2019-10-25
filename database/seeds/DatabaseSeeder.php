<?php

use Illuminate\Database\Seeder;
use App\Article;
use App\ArticleCategory;
use App\ArticleComment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(ArticleCategory::class, 5)->create();
        factory(Article::class, 100)->create();
        factory(ArticleComment::class, 1000)->create();
    }
}
