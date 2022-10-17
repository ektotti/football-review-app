<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence,
        'fixture_id'=> rand(1, 60),
        'body'=>$faker->realText,
        'image1'=>'/storage/image/sample_post_image',
        'image2'=>'/storage/image/sample_post_image',
        'image3'=>'/storage/image/sample_post_image',
        'image4'=>'/storage/image/sample_post_image',
    ];
});
