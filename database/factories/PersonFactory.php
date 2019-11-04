<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'date_of_birth' => '@todo null some times',
        'date_of_death' => '@todo null some times',
    ];
});
