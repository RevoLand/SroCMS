<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Article;
use App\User;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker)
{
    return [
        'slug' => $faker->unique()->slug(),
        'title' => $faker->sentence,
        'content' => $faker->realText(500),
        'author_id' => User::all()->random()->JID,
    ];
});
