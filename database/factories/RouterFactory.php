<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Router;
use Faker\Generator as Faker;

$factory->define(Router::class, function (Faker $faker) {
    return [
        'sapid' => $faker->unique()->numberBetween($min = 100000, $max = 1000000),
        'hostname' => $faker->unique()->domainName,
        'loopback' => $faker->unique()->ipv4,
        'mac_address' => $faker->unique()->macAddress
    ];
});
