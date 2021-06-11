<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\VideoCourseGallery;
use Faker\Generator as Faker;

$factory->define(VideoCourseGallery::class, function (Faker $faker) {

    $cr=$faker->dateTimeBetween('-70 days', '-1 days');

    return [
        'video_course_id' => rand(1, 50),
        'title'=> $faker->realText(rand(70, 250)),
        'duration_video'=>  date('H:i:s', rand(1, 1000)),
        'video'=> $faker->realText(rand(10, 50)) . '.mp4',
        'created_at'=> $cr,
        'updated_at'=> $cr,
    ];
});
