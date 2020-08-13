<?php

namespace perf\Navigation;

use PHPUnit\Framework\TestCase;

class BreadcrumbsTest extends TestCase
{
    private Breadcrumbs $breadcrumbs;

    protected function setUp(): void
    {
        $this->breadcrumbs = new Breadcrumbs();
    }

    public function testCountWithoutNodeWillReturnZero()
    {
        $this->assertSame(0, $this->breadcrumbs->count());
    }

    public function testCountWithNodesWillReturnExpected()
    {
        $this->breadcrumbs->add('foo');

        $this->assertSame(1, $this->breadcrumbs->count());
    }

    public function testObjectIsIterable()
    {
        $this->breadcrumbs->add('foo');
        $this->breadcrumbs->add('bar');

        $iterations = 0;

        foreach ($this->breadcrumbs as $node) {
            ++$iterations;

            $this->assertInstanceOf(BreadcrumbsNode::class, $node);
        }

        $this->assertSame(2, $iterations);
    }

    public function testObjectIsCountable()
    {
        $this->breadcrumbs->add('foo');
        $this->breadcrumbs->add('bar');

        $this->assertSame(2, count($this->breadcrumbs));
    }
}
