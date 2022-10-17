<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'player_1' => $faker->name,
        'player_2' => $faker->name,
        'player_3' => $faker->name,
        'player_4' => $faker->name,
        'player_5' => $faker->name,
        'player_6' => $faker->name,
        'player_7' => $faker->name,
        'player_8' => $faker->name,
        'player_9' => $faker->name,
        'player_10' => $faker->name,
        'player_11' => $faker->name,
        'player_12' => $faker->name,
        'player_13' => $faker->name,
        'player_14' => $faker->name,
        'player_15' => $faker->name,
        'player_16' => $faker->name,
        'player_17' => $faker->name,
        'player_18' => $faker->name,
        'player_19' => $faker->name,
        'player_20' => $faker->name,
    ];
});
