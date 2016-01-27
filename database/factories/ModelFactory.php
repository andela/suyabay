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
        'username'       => $faker->name,
        'email'          => $faker->email,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'role_id'        => 1,
    ];
});

$factory->define(Suyabay\Channel::class, function (Faker\Generator $faker) {
    return [
        'id'                  => 1,
        'channel_name'        => $faker->name,
        'channel_description' => $faker->sentence,
        'subscription_count'  => 10,
        "user_id"             => 1
    ];
});

$factory->define(Suyabay\Episode::class, function (Faker\Generator $faker) {
    return [
        'episode_name'          => $faker->name,
        'episode_description'   => $faker->sentence,
        'view_count'            => 10,
        'image'                 => "http://goo.gl/pm9GOw",
        'audio_mp3'             => "http://goo.gl/LkNP5M",
        'channel_id'            => 1,
        'status'                => 0,
        'likes'                 => 10,
    ];
});

$factory->define(Suyabay\Comment::class, function (Faker\Generator $faker) {
    return [
        'user_id'       => 1,
        'comments'       => $faker->text,
        'episode_id'    => 1,
    ];
});
