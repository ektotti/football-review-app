<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fixture;
use Faker\Generator as Faker;

$factory->define(Fixture::class, function (Faker $faker) {
    return [
        'match_week'=>$faker->numberBetween(1, 30),
        'hometeam_name'=>$faker->city,
        'awayteam_name'=>$faker->city,
        'fixture_date_time'=>$faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = 'Asia/Tokyo'),
        'fixture_url'=>$faker->url,
    ];
});
