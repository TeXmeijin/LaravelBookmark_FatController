<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bookmark;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/**
 * how to use factory command
$ docker-compose exec app php artisan tinker
Psy Shell v0.10.4 (PHP 7.4.8 — cli) by Justin Hileman
>>> factory(App\Models\User::class)->create()
=> App\Models\User {#3113
name: "吉田 桃子",
email: "dsasaki@example.com",
email_verified_at: "2020-07-15 11:52:29",
updated_at: "2020-07-15 11:52:29",
created_at: "2020-07-15 11:52:29",
id: 10,
}
>>> factory(App\Models\Bookmark::class)->create(['user_id' => 10])
=> App\Models\Bookmark {#3114
url: "http://tsuda.jp/odit-consectetur-et-id-enim.html",
comment: "Libero incidunt autem reprehenderit quia. Corporis optio aut ipsum est voluptates placeat excepturi dolores. Enim tempora quis id ut nostrum fugiat.",
page_title: "Est voluptas suscipit aperiam repellat autem quaerat ex.",
page_thumbnail_url: "https://lorempixel.com/640/480/?84327",
page_description: "Eos amet accusantium consequatur atque inventore. Tempora placeat dolor molestiae voluptatem aut.",
created_at: "2020-07-15 11:52:32",
updated_at: "2020-07-15 11:52:32",
user_id: 10,
id: 19,
}
 */

$factory->define(Bookmark::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
        'comment' => $faker->realText(100),
        'page_title' => '' . $faker->word,
        'page_thumbnail_url' => $faker->imageUrl(),
        'page_description' => $faker->realText(200),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});