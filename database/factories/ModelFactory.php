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
$factory->define(Leroy\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Leroy\Entities\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence(10)
    ];
});
$factory->define(Leroy\Entities\Product::class, function (Faker\Generator $faker) {
    return [
        'category_id' => null,
        'name' => $faker->name,
        'lm' => $faker->numberBetween(1000,10000),
        'description' => $faker->sentence(10),
        'free_shipping' => 0,
        'price' => number_format($faker->numberBetween(10,1000), 2)
    ];
});
