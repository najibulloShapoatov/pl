<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    $cr=$faker->dateTimeBetween('-700 days', '-1 days');
    $title= $faker->realText(rand(50, 90));
    return [
        'title'=> $title,
        'text_detail'=> $faker->realText(rand(1000, 10000)),
        'annonce_text'=> $faker->realText(rand(100, 250)),
        'viewed'=> $faker->numberBetween(100, 1000),
        'created_at'=> $cr,
        'updated_at'=> $cr,
  //      'image'=>'item.jpg'
    ];
});
