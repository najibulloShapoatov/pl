<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\BookCategory;
use Faker\Generator as Faker;

$factory->define(BookCategory::class, function (Faker $faker) {
    return [
        'title'=>$faker->realText(rand(30, 40)),
    ];
});
