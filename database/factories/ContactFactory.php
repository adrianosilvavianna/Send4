<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Contact::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'last_name' => $faker->lastName,
        'email'     =>$faker->unique()->emailSafe,
        'phone'     => $faker->unique()->phoneNumber
    ];
});
