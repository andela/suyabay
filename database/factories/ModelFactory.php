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

$factory->define(Suyabay\Pinky::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->name,
    ];
});

$factory->define(Suyabay\Movie::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->name,
        'audio_path' => '/audio/BlueDucks_FourFlossFiveSix.mp3',
        'image_url' => $faker->imageUrl($width, $height, 'cats', true, 'Faker'),
    ];
});

$factory->define(Suyabay\Episode::class, function (Faker\Generator $faker) {
    return [
        'episode_name' => $faker->name,
        'episode_description' => $faker->word,
        'view_count' => $faker->randomDigit,
        'image_url' => $faker->imageUrl($width, $height, 'cats', true, 'Faker'),
    ];
});
