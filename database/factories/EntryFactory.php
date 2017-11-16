<?php

use Faker\Generator as Faker;

$factory->define(App\Entry::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return Factory('App\User')->create()->id;
        },
        'journal_id' => function() {
            return Factory('App\Journal')->create()->id;
        },
        'body' => $faker->paragraph()
    ];
});
