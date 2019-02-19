<?php

namespace Dorvidas\QueryBuilder\Tests\Unit\Filters;

use Dorvidas\QueryBuilder\Filters\NotNullFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class NotNullFilterTest extends TestCase
{
    /** @test */
    public function null_filter_works()
    {
        $subject = new NotNullFilter();
        $builder = \Mockery::mock(Builder::class);
        $args = ['col'];
        $builder->shouldReceive('whereNotNull')->once()->withArgs([$args[0]]);
        $subject->apply($builder, null, $args);
    }
}