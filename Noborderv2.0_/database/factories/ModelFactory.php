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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'verified' => 1,
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\SecurityQuestion::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name
    ];
});

$factory->define(App\Skill::class, function (Faker\Generator $faker) {

    return [
        'skill_category_id' => rand(1, 40),
        'name' => $faker->name
    ];
});

$factory->define(App\Rate::class, function (Faker\Generator $faker) {

    return [
        'worker_id' => rand(1, 4),
        'project_id' => rand(1, 40),
        'rate' => rand(1, 5)
    ];
});
