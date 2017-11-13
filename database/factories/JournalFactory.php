<?php

use Faker\Generator as Faker;

$factory->define(App\Journal::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return Factory('App\User')->create()->id;
        },
        'name' => $faker->word()
    ];
});
