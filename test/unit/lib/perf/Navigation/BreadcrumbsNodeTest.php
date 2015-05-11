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
    public function testCreateWithTitle()
    {
        $title = 'foo';

        $node = BreadcrumbsNode::create($title);

        $this->assertSame($title, $node->getTitle());
    }

    /**
     *
     */
    public function testCreateWithoutLink()
    {
        $title = 'foo';

        $node = BreadcrumbsNode::create($title);

        $this->assertFalse($node->hasLink());
    }

    /**
     *
     */
    public function testCreateWithLink()
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
    public function testHasAttributeWithExistingAttributeWillReturnTrue()
    {
        $title      = 'foo';
        $link       = null;
        $attribute  = 'bar';
        $attributes = array(
            $attribute => 'baz',
        );

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->assertTrue($node->hasAttribute($attribute));
    }

    /**
     *
     */
    public function testHasAttributeWithNonExistingAttributeWillReturnFalse()
    {
        $title      = 'foo';
        $link       = null;
        $attribute  = 'bar';
        $attributes = array();

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->assertFalse($node->hasAttribute($attribute));
    }

    /**
     *
     */
    public function testGetAttributeWithExistingAttributeWillReturnExpected()
    {
        $title      = 'foo';
        $link       = null;
        $attribute  = 'bar';
        $attributes = array(
            $attribute => 'baz',
        );

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->assertSame('baz', $node->getAttribute($attribute));
    }

    /**
     *
     */
    public function testGetAttributeWithNonExistingAttributeWillThrowException()
    {
        $title      = 'foo';
        $link       = null;
        $attribute  = 'bar';
        $attributes = array();

        $node = BreadcrumbsNode::create($title, $link, $attributes);

        $this->setExpectedException('\\DomainException', "Attribute '{$attribute}' not defined.");

        $node->getAttribute($attribute);
    }
}
