<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

//$factory->define(Model::class, function (Faker $faker) {
//    return [
//        //
//    ];
//});

$factory->define(App\Models\Link::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'link' => $faker->url,
    ];
});