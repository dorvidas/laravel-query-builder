<?php

namespace Dorvidas\QueryBuilder\Tests\Unit\Filters;

use Dorvidas\QueryBuilder\Filters\GreaterThanEqualFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class GreaterThanEqualFilterTest extends TestCase
{
    /** @test */
    public function greater_than_equal_filter_works()
    {
        $subject = new GreaterThanEqualFilter();
        $builder = \Mockery::mock(Builder::class);
        $value = 1;
        $args = ['col'];
        $builder->shouldReceive('where')->once()->withArgs([$args[0], '>=', $value]);
        $subject->apply($builder,$value, $args);
    }
}