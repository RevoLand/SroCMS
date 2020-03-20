<?php

use App\Article;
use App\ArticleCategory;
use App\ArticleComment;
use App\Menu;
use App\Page;
use App\Sidebar;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        factory(ArticleCategory::class, 6)->create();
        factory(Article::class, 30)->create();
        factory(ArticleComment::class, 200)->create();
        factory(Sidebar::class, 3)->create();
        factory(Page::class, 10)->create();
    }
}
