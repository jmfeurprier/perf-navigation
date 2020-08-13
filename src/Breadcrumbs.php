<?php

namespace perf\Navigation;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Iterator;

class Breadcrumbs implements IteratorAggregate, Countable
{
    /**
     * @var BreadcrumbsNode[]
     */
    private array $nodes = [];

    public function add(string $title, ?string $link = null, array $attributes = []): self
    {
        $node = BreadcrumbsNode::create($title, $link, $attributes);

        return $this->addNode($node);
    }

    public function addNode(BreadcrumbsNode $node): self
    {
        $this->nodes[] = $node;

        return $this;
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->nodes);
    }
}
