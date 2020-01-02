<?php

 /**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use App\Constants\UserConstants;
use App\Models\UserProfile;
use Faker\Generator as Faker;

$factory->define(UserProfile::class, function (Faker $faker) {
    return [
        'birth_date' => now(),
        'sex' => UserConstants::SEX[rand(0,1)],
        'tag_line' => $faker->title,
        'abn' => $faker->text,
        'description' => $faker->text,
    ];
});
