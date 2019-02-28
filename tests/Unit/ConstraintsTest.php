<?php

namespace Dorvidas\QueryBuilder\Tests\Unit;

use Dorvidas\QueryBuilder\Constraints;
use Dorvidas\QueryBuilder\Exceptions\IncludeNotAllowedException;
use Dorvidas\QueryBuilder\Tests\TestCase;

class ConstraintsTest extends TestCase
{
    /** @test */
    public function it_will_throw_exception_if_trying_to_include_now_allowed_one()
    {
        $this->expectException(IncludeNotAllowedException::class);
        $subject = new Constraints();
        $subject->allowIncludes(['posts']);
        $includes = [
            'posts' => [],
            'roles' => [],
        ];
        $subject->checkIncludes($includes);
    }

    /** @test */
    public function it_will_pass_when_exact_include_allowed()
    {
        $subject = new Constraints();
        $subject->allowIncludes(['posts']);
        $includes = [
            'posts' => [],
        ];
        $this->assertTrue($subject->checkIncludes($includes));
    }

    /** @test */
    public function it_will_pass_deeper_include_is_allowed()
    {
        $subject = new Constraints();
        $subject->allowIncludes(['posts.comments']);
        $includes = [
            'posts' => [],
        ];
        $this->assertTrue($subject->checkIncludes($includes));
    }
}