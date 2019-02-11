<?php

namespace Dorvidas\QueryBuilder\Tests;

use Dorvidas\QueryBuilder\Tests\Models\TestModel;

class QueryBuilderTest extends TestCase
{
    /** @test */
    public function it_can_filter_root_model()
    {
        $this->getJson('/test-model?filter[eq:id]=1');
        $actual =TestModel::where('id', 1);
        $expected = TestModel::buildFromRequest();

        $this->assertEquals($actual->toSql(), $expected->toSql());
        $this->assertEquals($actual->getBindings(), $expected->getBindings());
    }
}