<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker)
{
    return [
        'title' => $faker->sentence(2),
        'slug' => $faker->slug,
        'content' => $faker->randomHtml(6, 6),
        'middleware' => $faker->optional()->randomElement(['guest', 'auth', 'verified']),
        'enabled' => $faker->boolean,
    ];
});
