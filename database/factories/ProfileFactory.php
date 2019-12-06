<?php

 /**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
use Faker\Generator as Faker;

$factory->define(\App\Models\Profile::class, function (Faker $faker) {
    return [
        'birth_date' => now(),
        //'address' => ,
        'sex' => \App\User::SEX[rand(0,1)],
        'teg_line' => $faker->title,
        'abn' => $faker->text,
        'description' => $faker->text,
    ];
});
