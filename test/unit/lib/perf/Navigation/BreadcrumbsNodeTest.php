<?php

namespace perf\Navigation;

/**
 *
 */
class BreadcrumbsNodeTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testConstructorWithTitle()
    {
        $title = 'foo';

        $node = BreadcrumbsNode::create($title);

        $this->assertSame($title, $node->getTitle());
    }

    /**
     *
     */
    public function testConstructorWithoutLink()
    {
        $title = 'foo';

        $node = BreadcrumbsNode::create($title);

        $this->assertFalse($node->hasLink());
    }

    /**
     *
     */
    public function testConstructorWithLink()
    {
        $title = 'foo';
        $link  = 'bar';

        $node = BreadcrumbsNode::create($title, $link);

        $this->assertTrue($node->hasLink());
        $this->assertSame($link, $node->getLink());
    }

    /**
     *
     * @expectedException \RuntimeException
     */
    public function testGetLinkWithoutLinkThrowsException()
    {
        $title = '';

        $node = BreadcrumbsNode::create($title);

        $node->getLink();
    }

    /**
     *
     */
    public function testConstructorWithAttribute()
    {
        $title = 'foo';
        $link  = null;
        $attributes = array(
            'bar' => 'baz',
        );

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->assertTrue($node->hasAttribute('bar'));
        $this->assertSame('baz', $node->getAttribute('bar'));
    }
}
