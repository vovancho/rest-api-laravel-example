<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => title_case($faker->unique()->words($nb = rand(1, 4), true)),
        'price' => $faker->numberBetween(1000, 9000),
    ];
});
