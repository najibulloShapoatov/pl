<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\Community;
use Faker\Generator as Faker;

$factory->define(Community::class, function (Faker $faker) {

    return [
        'title' => $faker->realText(rand(10, 200)),
        'user_id' => rand(1, 3),
        'description' => $faker->realText(rand(100, 1000)),

    ];
});
