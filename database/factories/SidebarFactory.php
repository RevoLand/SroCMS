<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Sidebar;
use Faker\Generator as Faker;

$factory->define(Sidebar::class, function (Faker $faker)
{
    return [
        'title' => $faker->sentence,
        'content' => $faker->randomHtml,
        'order' => $faker->randomDigit,
    ];
});
