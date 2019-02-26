<?php

namespace Dorvidas\QueryBuilder\Tests\Unit\Filters;

use Dorvidas\QueryBuilder\Filters\LikeLeftFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class LikeLeftFilterTest extends TestCase
{
    /** @test */
    public function like_left_filter_works()
    {
        $subject = new LikeLeftFilter();
        $builder = \Mockery::mock(Builder::class);
        $value = 'test';
        $args = ['col'];
        $builder->shouldReceive('where')->once()->withArgs([$args[0], 'like', '%'. $value]);
        $subject->apply($builder, $value, $args);
    }
}