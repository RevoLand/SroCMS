<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ArticleCategory;
use App\Model;
use Faker\Generator as Faker;

$factory->define(ArticleCategory::class, function (Faker $faker) {
    return [
        'slug' => $faker->unique()->slug(),
        'title' => $faker->realText(50),
        'is_visible' => true
    ];
});
