<?php

namespace Dorvidas\QueryBuilder\Tests\Filters;

use Dorvidas\QueryBuilder\Filters\NotInFilter;
use Dorvidas\QueryBuilder\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;

class NotInFilterTest extends TestCase
{
    protected $subject;
    protected $builder;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new NotInFilter();
        $this->builder = \Mockery::mock(Builder::class);
    }

    /** @test */
    public function not_in_filter_works()
    {
        $value = [1, 2];
        $args = ['col'];
        $this->builder->shouldReceive('whereNotIn')->once()->withArgs([$args[0], $value]);
        $this->subject->apply($this->builder, $value, $args);
    }

    /** @test */
    public function it_can_accept_non_array_value()
    {
        $value = '1,2';
        $args = ['col'];
        $this->builder->shouldReceive('whereNotIn')->once()->withArgs([$args[0], explode(',', $value)]);
        $this->subject->apply($this->builder, $value, $args);
    }
}