<?php

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define( Task::class, function (Faker $faker) {
    $random = rand(0,1);
    return [
        'title' => $faker->jobTitle,
        'details' => $faker->text,
        'date' => now(),
        'price_total' =>  $random ? rand(50,200) : null,
        'price_hourly' => !$random ? rand(5,50) : null,
    ];
});
