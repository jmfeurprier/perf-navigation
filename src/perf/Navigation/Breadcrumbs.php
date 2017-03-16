<?php

namespace perf\Navigation;

/**
 *
 *
 */
class Breadcrumbs implements \IteratorAggregate, \Countable
{

    /**
     *
     *
     * @var BreadcrumbsNode[]
     */
    private $nodes = array();

    /**
     *
     *
     * @param string $title
     * @param null|string $link
     * @param {string:mixed} $attributes
     * @return Breadcrumbs Fluent return.
     */
    public function add($title, $link = null, array $attributes = array())
    {
        $node = BreadcrumbsNode::create($title, $link, $attributes);

        return $this->addNode($node);
    }

    /**
     *
     *
     * @param BreadcrumbsNode $node
     * @return Breadcrumbs Fluent return.
     */
    public function addNode(BreadcrumbsNode $node)
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     *
     *
     * @return int
     */
    public function count()
    {
        return count($this->nodes);
    }

    /**
     *
     *
     * @return \Iterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->nodes);
    }
}
