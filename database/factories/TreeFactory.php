<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tree;
use Faker\Generator as Faker;

$factory->define(Tree::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
