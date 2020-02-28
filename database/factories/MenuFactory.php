<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Menu;
use App\Page;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker)
{
    return [
        'title' => $faker->sentence(2),
        'href' => $faker->url,
        'page_id' => $faker->optional()->passthrough(Page::all()->random()->id),
        'location' => $faker->randomElement(['header', 'sidebar']),
        'route' => $faker->optional()->randomElement(['home', 'users.login_form', 'users.register_form', 'password.request', 'users.current_user', 'users.edit_form']),
        'order' => $faker->randomDigit,
    ];
});
