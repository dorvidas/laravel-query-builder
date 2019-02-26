<?php

namespace Dorvidas\QueryBuilder\Tests\Unit\Filters;

use Dorvidas\QueryBuilder\Filters\LikeBothFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class LikeBothFilterTest extends TestCase
{
    /** @test */
    public function like_both_filter_works()
    {
        $subject = new LikeBothFilter();
        $builder = \Mockery::mock(Builder::class);
        $value = 'test';
        $args = ['col'];
        $builder->shouldReceive('where')->once()->withArgs([$args[0], 'like', '%'. $value . '%']);
        $subject->apply($builder, $value, $args);
    }
}