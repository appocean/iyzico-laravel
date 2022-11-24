<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Appocean\Payment\Models\Plan;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\Appocean\Payment\Models\Plan::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'product_id' => 1,
        'trial_period' => 5,
        'trial_interval' => Plan::INTERVAL_FOR_DAY,
        'invoice_period' => 1,
        'invoice_interval' => Plan::INTERVAL_FOR_MONTH,
        'sort_order' => 1,
        'currency' => 'TRY',
        'price' => 79.99,
        'signup_fee' => 0
    ];
});
