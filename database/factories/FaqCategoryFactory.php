<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\FaqCategory::class, function (Faker $faker) {
    return [
        'title'=> $faker->realText(rand(10, 100)),
    ];
});
