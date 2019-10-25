<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\ArticleComment;
use App\Model;
use App\User;
use Faker\Generator as Faker;

$factory->define(ArticleComment::class, function (Faker $faker) {
    return [
        'article_id' => Article::all()->random()->id,
        'user_id' => User::all()->random()->JID,
        'content' => $faker->realText(255)
    ];
});
