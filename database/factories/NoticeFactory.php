<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Model\Notice;
use Faker\Generator as Faker;

$factory->define(Notice::class, function (Faker $faker) {
    $cr=$faker->dateTimeBetween('-700 days', '-1 days');
    return [
        'title'=> $faker->realText(rand(50, 90)),
        'who_can_see'=> rand(2, 5),
        'description'=> $faker->realText(rand(900, 5000)),
        'created_at'=> $cr,
        'updated_at'=> $cr,

    ];
});
