
<?php
use Faker\Generator as Faker;
use Dorvidas\QueryBuilder\Tests\Models\UserModel;

$factory->define(UserModel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});