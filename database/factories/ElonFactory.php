<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\Elon::class, function (Faker $faker) {
    $cr=$faker->dateTimeBetween('-700 days', '-1 days');
    $title= $faker->realText(rand(50, 90));
    return [
        'category_id'=> rand(1, 4),
        'user_id'=> rand(1, 3),
        'title'=> $faker->realText(rand(60, 255)),
        'description'=> $faker->realText(rand(500, 3000)),
        'phone_no'=> rand(900000909, 988726765),
        'status' => 1,
        'published_at' => $cr,
        'created_at'=> $cr,
        'updated_at'=> $cr,
        //      'image'=>'item.jpg'
    ];
});
