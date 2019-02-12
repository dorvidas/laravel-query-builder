<?php

use Faker\Generator as Faker;
use Dorvidas\QueryBuilder\Tests\Models\PostModel;

$factory->define(PostModel::class, function (Faker $faker) {
    return [
        'body' => $faker->word,
        'user_id' => factory(\Dorvidas\QueryBuilder\Tests\Models\UserModel::class),
        'published' => true,
    ];
});