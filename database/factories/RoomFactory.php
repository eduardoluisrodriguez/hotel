<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Room::class, function (Faker $faker) {
    return [
        'number'   => $faker->numerify(),
        'floor'    => $faker->numerify(),
        'capacity' => $faker->numberBetween(1, 99),
        'price'    => $faker->numerify(),
        'comment'  => 'test comment',
    ];
});
