<?php

namespace Dorvidas\QueryBuilder\Feature\Tests;

use Dorvidas\QueryBuilder\Constraints;
use Dorvidas\QueryBuilder\Exceptions\IncludeNotAllowedException;
use Dorvidas\QueryBuilder\Tests\Models\CommentModel;
use Dorvidas\QueryBuilder\Tests\Models\PostModel;
use Dorvidas\QueryBuilder\Tests\Models\UserModel;
use Dorvidas\QueryBuilder\Tests\TestCase;

class QueryBuilderTest extends TestCase
{
    /** @test */
    public function it_can_filter_root_model()
    {
        factory(UserModel::class)->create(['active' => false]);
        factory(UserModel::class)->create(['active' => true]);

        $this->getJson('/users?filter[eq:active]=1');

        $this->assertEquals(UserModel::where('active', 1)->get()->toArray(), UserModel::buildFromRequest()->get()->toArray());
    }

    /** @test */
    public function it_can_include_resources()
    {
        factory(UserModel::class)
            ->create()
            ->each(function ($user) {
                $user->posts()->save(factory(PostModel::class)->create());
            });

        $this->getJson('/users?include=posts');

        $this->assertEquals(UserModel::with('posts')->get()->toArray(), UserModel::buildFromRequest()->get()->toArray());
    }

    /** @test */
    public function it_can_include_resources_and_filter_on_them()
    {
        factory(UserModel::class)
            ->create()
            ->each(function ($user) {
                $user->posts()->save(factory(PostModel::class)->create(['published' => 1, 'user_id' => $user->id]));
                $user->posts()->save(factory(PostModel::class)->create(['published' => 0, 'user_id' => $user->id]));
            });

        $this->getJson('/users?filter[posts.eq:published]=1&include=posts');

        $expected = UserModel::with(['posts' => function ($query) {
            $query->where('published', 1);
        }])->get()->toArray();

        $this->assertEquals($expected, UserModel::buildFromRequest()->get()->toArray());
    }

    /** @test */
    public function it_can_include_include_and_filter_deep_nested_resources()
    {
        $user = factory(UserModel::class)->create();
        $post = factory(PostModel::class)->create(['user_id' => $user->id]);
        $commentUnapproved = factory(CommentModel::class)->create([
            'commentable_id' => $post->id,
            'commentable_type' => PostModel::class,
            'approved' => 0
        ]);
        $commentApproved = factory(CommentModel::class)->create([
            'commentable_id' => $post->id,
            'commentable_type' => PostModel::class,
            'approved' => 1
        ]);
        $this->getJson('/users?filter[posts.comments.eq:approved]=1&include=posts.comments');

        $expected = UserModel::with(['posts.comments' => function ($query) {
            $query->where('approved', 1);
        }])->get()->toArray();

        $this->assertEquals($expected, UserModel::buildFromRequest()->get()->toArray());
    }

    /** @test */
    public function it_throw_exception_if_there_are_include_constrains_and_include_not_allowed()
    {
        $this->getJson('/users?include=posts');
        $this->expectException(IncludeNotAllowedException::class);
        UserModel::buildFromRequest((new Constraints())->allowIncludes([]))->get()->toArray();
    }
}