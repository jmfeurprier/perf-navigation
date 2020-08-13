<?php

namespace perf\Navigation;

use perf\Navigation\Exception\BreadcrumbsException;
use PHPUnit\Framework\TestCase;

class BreadcrumbsNodeTest extends TestCase
{
    public function testCreateWithTitle()
    {
        $title = 'foo';

        $node = BreadcrumbsNode::create($title);

        $this->assertSame($title, $node->getTitle());
    }

    public function testCreateWithoutLink()
    {
        $title = 'foo';

        $node = BreadcrumbsNode::create($title);

        $this->assertFalse($node->hasLink());
    }

    public function testCreateWithLink()
    {
        $title = 'foo';
        $link  = 'bar';

        $node = BreadcrumbsNode::create($title, $link);

        $this->assertTrue($node->hasLink());
        $this->assertSame($link, $node->getLink());
    }

    public function testGetLinkWithoutLinkThrowsException()
    {
        $title = '';

        $node = BreadcrumbsNode::create($title);

        $this->expectException(BreadcrumbsException::class);

        $node->getLink();
    }

    public function testHasAttributeWithExistingAttributeWillReturnTrue()
    {
        $title      = 'foo';
        $link       = null;
        $attribute  = 'bar';
        $attributes = [
            $attribute => 'baz',
        ];

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->assertTrue($node->hasAttribute($attribute));
    }

    public function testHasAttributeWithNonExistingAttributeWillReturnFalse()
    {
        $title      = 'foo';
        $link       = null;
        $attribute  = 'bar';
        $attributes = [];

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->assertFalse($node->hasAttribute($attribute));
    }

    public function testGetAttributeWithExistingAttributeWillReturnExpected()
    {
        $title      = 'foo';
        $link       = null;
        $attribute  = 'bar';
        $attributes = [
            $attribute => 'baz',
        ];

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->assertSame('baz', $node->getAttribute($attribute));
    }

    public function testGetAttributeWithNonExistingAttributeWillThrowException()
    {
        $title      = 'foo';
        $link       = null;
        $attribute  = 'bar';
        $attributes = [];

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->expectException(BreadcrumbsException::class);
        $this->expectExceptionMessage("Attribute '{$attribute}' not defined.");

        $node->getAttribute($attribute);
    }
}
