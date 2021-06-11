<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\VideoCourse;
use Faker\Generator as Faker;

$factory->define(VideoCourse::class, function (Faker $faker) {

    $cr=$faker->dateTimeBetween('-70 days', '-1 days');

    return [
        'category_id' => rand(1, 6),
        'user_id' => rand(1, 5),
        'title'=> $faker->realText(rand(70, 250)),
        'description'=> $faker->realText(rand(700, 7000)),
        'duration'=>  date('H:i:s', rand(1,54000)),
        'is_active'=> 1,
        'created_at'=> $cr,
        'updated_at'=> $cr,
    ];
});
