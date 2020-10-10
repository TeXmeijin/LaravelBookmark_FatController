<?php

/** @var Factory $factory */


use App\Models\BookmarkCategory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(BookmarkCategory::class, function (Faker $faker) {
    return [
        'display_name' => 'カテゴリ' . $faker->word(),
        'slug' => urlencode($faker->sentence(2)),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});