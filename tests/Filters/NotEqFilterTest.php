<?php

namespace Dorvidas\QueryBuilder\Tests\Filters;

use Dorvidas\QueryBuilder\Filters\NotEqFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class NotEqFilterTest extends TestCase
{
    /** @test */
    public function not_equal_filter_works()
    {
        $subject = new NotEqFilter();
        $builder = \Mockery::mock(Builder::class);
        $value = 1;
        $args = ['col'];
        $builder->shouldReceive('where')->once()->withArgs([$args[0], '!=', $value]);
        $subject->apply($builder,$value, $args);
    }
}