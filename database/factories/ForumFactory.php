<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\Forum;
use Faker\Generator as Faker;

$factory->define(Forum::class, function (Faker $faker) {
    $cr=$faker->dateTimeBetween('-10 days', '-1 days');
    return [
        'user_id'=> 2,
        'category_id'=> rand(1, 4),
        'f_like'=> rand(10, 90),
        'title'=> $faker->realText(rand(100, 250)),
        'text'=> $faker->realText(rand(1000, 25000)),
        'viewed'=> $faker->numberBetween(100, 1000),
        'created_at'=> $cr,
        'updated_at'=> $cr,
    ];
});
