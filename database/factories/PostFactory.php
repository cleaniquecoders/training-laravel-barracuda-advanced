<?php

use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        'title'       => $faker->sentence,
        'description' => $faker->text,
        'user_id'     => $faker->randomElement(range(1, 10)),
    ];
});
