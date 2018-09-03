<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Tariff::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'price' => rand(10000, 1000000) / 100,
        'days' => function () {
            $days = [];
            for ($i = 1; $i <= 7; ++$i) {
                if (rand(0, 1)) {
                    $days[] = $i;
                }
            }

            // There should be at least one day
            if (!$days) {
                $days[] = rand(1, 7);
            }

            return $days;
        }
    ];
});
