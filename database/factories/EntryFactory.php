<?php

use Faker\Generator as Faker;

$factory->define(App\Entry::class, function (Faker $faker) {
    return [
        'journal_id' => function() {
            return Factory('App\Journal')->create()->id;
        },
        'body' => $faker->paragraph()
    ];
});
