<?php

use Faker\Generator as Faker;

$factory->define(\Dorvidas\QueryBuilder\Tests\Models\CommentModel::class, function (Faker $faker) {
    return [
        'body' => $faker->word,
        'commentable_id' => factory(\Dorvidas\QueryBuilder\Tests\Models\PostModel::class),
        'commentable_type' => \Dorvidas\QueryBuilder\Tests\Models\PostModel::class,
        'approved' => 1
    ];
});