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
     * @return Breadcrumbs Fluent return.
     */
    public function add($title, $link = null)
    {
        $this->nodes[] = BreadcrumbsNode::create($title, $link);

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
