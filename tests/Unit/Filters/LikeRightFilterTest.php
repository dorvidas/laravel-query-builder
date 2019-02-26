<?php

namespace Dorvidas\QueryBuilder\Tests\Unit\Filters;

use Dorvidas\QueryBuilder\Filters\LikeRightFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class LikeRightFilterTest extends TestCase
{
    /** @test */
    public function like_right_filter_works()
    {
        $subject = new LikeRightFilter();
        $builder = \Mockery::mock(Builder::class);
        $value = 'test';
        $args = ['col'];
        $builder->shouldReceive('where')->once()->withArgs([$args[0], 'like', $value . '%']);
        $subject->apply($builder, $value, $args);
    }
}