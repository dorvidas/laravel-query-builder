<?php

namespace Dorvidas\QueryBuilder\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Dorvidas\QueryBuilder\QueryBuilderServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->withFactories(__DIR__.'/factories');
    }

    protected function setUpDatabase(Application $app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->boolean('active')->default(true);
        });

        $app['db']->connection()->getSchemaBuilder()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->text('body');
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('commentable_type');
            $table->unsignedInteger('commentable_id');
            $table->text('body');
            $table->boolean('approved')->default(true);
            $table->timestamps();
        });
    }

    protected function getPackageProviders($app)
    {
        return [QueryBuilderServiceProvider::class];
    }
}