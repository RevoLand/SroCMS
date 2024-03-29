<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\ArticleCategory;
use Faker\Generator as Faker;

$factory->define(ArticleCategory::class, function (Faker $faker)
{
    return [
        'slug' => $faker->unique()->slug(),
        'name' => $faker->realText(15),
    ];
});
