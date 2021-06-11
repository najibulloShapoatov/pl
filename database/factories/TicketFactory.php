<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    $cr=$faker->dateTimeBetween('-20 days', '-1 days');
    return [
        'parent_id' => 1,
        'title' => $faker->realText(rand(100, 1000)),
        'user_id' => rand(2, 3),
        'created_at'=> $cr,
        'updated_at'=> $cr,
    ];
});
