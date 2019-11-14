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
        factory(ArticleCategory::class, 5)->create();
        factory(Article::class, 100)->create();
        factory(ArticleComment::class, 1000)->create();
        factory(Sidebar::class, 5)->create();
        factory(Page::class, 10)->create();
        factory(Menu::class, 20)->create();
    }
}
