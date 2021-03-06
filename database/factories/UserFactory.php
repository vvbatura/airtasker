<?php

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use App\Constants\UserConstants;
use App\User;
use Faker\Generator as Faker;

$factory->define( User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'password' => 'Qwerty1@',
        'type' => rand(0,1) ?  UserConstants::TYPES : [UserConstants::TYPES[rand(0,1)]],
        'status' =>  UserConstants::STATUS_ACTIVE,
        'verified_at' => now(),
        'remember_token' => User::makeHash(),
    ];
});
