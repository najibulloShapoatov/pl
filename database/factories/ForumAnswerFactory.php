<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\ForumAnswer::class, function (Faker $faker) {
    $cr=$faker->dateTimeBetween('-7 days', '-1 days');
    return [
        'user_id'=> 2,
        'forum_id'=> rand(1, 10),
        'f_like'=> rand(10, 90),
        'text'=> $faker->realText(rand(500, 2500)),
        'created_at'=> $cr,
        'updated_at'=> $cr,
    ];
});
