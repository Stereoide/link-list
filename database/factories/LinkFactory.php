<?php

use Faker\Generator as Faker;

$factory->define(App\Link::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
        'title' => $faker->sentence,
        'read_at' => null,
        'dismissed_at' => null,
    ];
});
