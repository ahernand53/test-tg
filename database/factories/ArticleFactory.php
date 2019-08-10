<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'register_number' => $faker->uuid,
        'quantity' => $faker->numberBetween(1, 10)
    ];
});
