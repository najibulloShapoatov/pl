<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\Faq::class, function (Faker $faker) {
    return [
        'category_id' => rand(1, 10),
        'title'=> $faker->realText(rand(10, 100)),
        'description'=> $faker->realText(rand(300, 1500)),
    ];
});
