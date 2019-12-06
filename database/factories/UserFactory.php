<?php

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
use Faker\Generator as Faker;

$factory->define( \App\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'password' => 'Qwerty1@',
        'type' => rand(0,1) ?  json_encode(\App\User::TYPES) : json_encode([ \App\User::TYPES[rand(0,1)]]),
        'status' =>  \App\User::STATUS_ACTIVE,
        'verify_type' =>  \App\User::VERIFIES[rand(0,1)],
        'verified_at' => now(),
        'remember_token' => \Illuminate\Support\Str::random(10),
    ];
});
