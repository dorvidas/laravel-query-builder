<?php

namespace Dorvidas\QueryBuilder\Tests\Unit\Filters;

use Dorvidas\QueryBuilder\Filters\InFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class InFilterTest extends TestCase
{
    protected $subject;
    protected $builder;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new InFilter();
        $this->builder = \Mockery::mock(Builder::class);
    }

    /** @test */
    public function in_filter_works()
    {
        $value = [1, 2];
        $args = ['col'];
        $this->builder->shouldReceive('whereIn')->once()->withArgs([$args[0], $value]);
        $this->subject->apply($this->builder, $value, $args);
    }

    /** @test */
    public function it_can_accept_non_array_value()
    {
        $value = '1,2';
        $args = ['col'];
        $this->builder->shouldReceive('whereIn')->once()->withArgs([$args[0], explode(',', $value)]);
        $this->subject->apply($this->builder, $value, $args);
    }
}