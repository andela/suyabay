<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Suyabay\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Suyabay\Episode::class, function (Faker\Generator $faker) {
            return [
                'episode_name'        => $faker->name,
                'episode_description' => $faker->sentence,
                'view_count'          => 10,
                'image'               => "http://goo.gl/pm9GOw",
                'audio_mp3' => "http://goo.gl/LkNP5M",
                'channel_id' => 9,
            ];
        });