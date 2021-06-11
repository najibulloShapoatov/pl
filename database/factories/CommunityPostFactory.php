<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\CommunityPost;
use Faker\Generator as Faker;

$factory->define(CommunityPost::class, function (Faker $faker) {
    $cr=$faker->dateTimeBetween('-70 days', '-1 days');
    return [
        'community_id' => rand(4, 30),
        'text' => $faker->realText(rand(200, 500)),
        'created_at'=> $cr,
        'updated_at'=> $cr,
    ];
});
