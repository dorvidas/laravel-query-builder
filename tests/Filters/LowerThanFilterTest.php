<?php

namespace Dorvidas\QueryBuilder\Tests\Filters;

use Dorvidas\QueryBuilder\Filters\LowerThanFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class LowerThanFilterTest extends TestCase
{
    /** @test */
    public function lower_than_equal_filter_works()
    {
        $subject = new LowerThanFilter();
        $builder = \Mockery::mock(Builder::class);
        $value = 1;
        $args = ['col'];
        $builder->shouldReceive('where')->once()->withArgs([$args[0], '<', $value]);
        $subject->apply($builder, $value, $args);
    }
}