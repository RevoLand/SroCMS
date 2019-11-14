<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Menu;
use App\Page;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker)
{
    return [
        'title' => $faker->sentence,
        'href' => $faker->url,
        'target_page_id' => Page::all()->random()->id,
        'location' => $faker->randomElement(['header', 'sidebar']),
        'order' => $faker->randomDigit,
    ];
});
