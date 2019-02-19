<?php

namespace Dorvidas\QueryBuilder\Tests\Unit\Filters;

use Dorvidas\QueryBuilder\Filters\EqFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class EqFilterTest extends TestCase
{
    /** @test */
    public function equal_filter_works()
    {
        $subject = new EqFilter();
        $builder = \Mockery::mock(Builder::class);
        $value = 1;
        $args = ['col'];
        $builder->shouldReceive('where')->once()->withArgs([$args[0], '=', $value]);
        $subject->apply($builder,$value, $args);
    }
}