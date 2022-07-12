<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fixture;
use Faker\Generator as Faker;

$factory->define(Fixture::class, function (Faker $faker) {
    return [
        'match_week'=>rand(0, 30),
        'hometeam_name'=>$faker->company,
        'awayteam_name'=>$faker->company,
        'fixture_date_time'=>$faker->dateTime,
        'fixture_url'=>$faker->url,
    ];
});
