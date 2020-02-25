<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use App\User;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
