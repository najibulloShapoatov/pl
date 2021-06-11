<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\PoolResult;
use Faker\Generator as Faker;

$factory->define(PoolResult::class, function (Faker $faker) {
    $cr=$faker->dateTimeBetween('-70 days', '-1 days');
    $title= $faker->realText(rand(50, 90));
    return [
        'pool_answer_id' =>rand(1, 4),
        'ip_cookie' => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255). '.' . rand(0, 255),
        'created_at'=> $cr,
        'updated_at'=> $cr,
    ];
});
