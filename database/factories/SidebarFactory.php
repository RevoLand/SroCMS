<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Sidebar;
use Faker\Generator as Faker;

$factory->define(Sidebar::class, function (Faker $faker)
{
    return [
        'title' => $faker->sentence(3),
        'content' => $faker->randomHtml(4, 4),
        'order' => $faker->randomDigit,
        'enabled' => $faker->boolean,
    ];
});
