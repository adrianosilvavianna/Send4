<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Message::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(10),
        'contact_id' => factory(\App\Models\Contact::class)->create()->id
    ];
});
