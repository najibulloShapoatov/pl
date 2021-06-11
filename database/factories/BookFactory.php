<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Books;
use Faker\Generator as Faker;

$factory->define(Books::class, function (Faker $faker) {
    $title=$faker->realText(rand(50,80));
    $isbn=$faker->isbn13;
    $cr=$faker->dateTimeBetween('-50 days', '-4 days');
    return [
        'title'=>$title,
        'autor'=>$faker->name,
//        'image'=>'background.jpg',
        'read'=>$faker->numberBetween(200, 500),
        'viewed'=>$faker->numberBetween(50, 400),
        'downloaded'=>$faker->numberBetween(20, 200),
        'category_id'=>$faker->numberBetween(1, 10),
        'isbn'=>$isbn,
        'year'=>$faker->numberBetween(1970, 2018),
        'page'=>$faker->numberBetween(100, 500),
        'type'=>$faker->word,
        'lang'=> 'zabon' . $faker->word,
        'publish'=>$faker->realText(rand(20,70)),
        'description'=>$faker->realText(rand(1000, 2000)),
        'file'=>$faker->url,
        'created_at'=> $cr,
        'updated_at'=> $cr,

            ];
});
