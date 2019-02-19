<?php

namespace Dorvidas\QueryBuilder\Tests\Unit\Filters;

use Dorvidas\QueryBuilder\Filters\NullFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class NullFilterTest extends TestCase
{
    /** @test */
    public function null_filter_works()
    {
        $subject = new NullFilter();
        $builder = \Mockery::mock(Builder::class);
        $args = ['col'];
        $builder->shouldReceive('whereNull')->once()->withArgs([$args[0]]);
        $subject->apply($builder, null, $args);
    }
}