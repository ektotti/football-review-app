<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence,
        // 'user_id'=> function () {
        //     return factory(App\User::class)->create()->id;
        // },
        'user_id'=>rand(1, 25),
        'fixture_id'=> function (){
            return factory(App\Fixture::class)->create()->id;
        },
        'body'=>$faker->realText,
        'image1'=>$faker->imageurl,
        'image2'=>$faker->imageurl,
        'image3'=>$faker->imageurl,
        'image4'=>$faker->imageurl,
    ];
});
