<?php

namespace perf\Navigation;

/**
 *
 *
 */
class BreadcrumbsNode
{

    /**
     *
     *
     * @var string
     */
    private $title;

    /**
     *
     *
     * @var null|string
     */
    private $link;

    /**
     * Static constructor.
     *
     * @param string $title
     * @param null|string $link
     * @return BreadcrumbsNode
     */
    public static function create($title, $link = null)
    {
        return new self($title, $link);
    }

    /**
     * Constructor.
     *
     * @param string $title
     * @param null|string $link
     * @return void
     */
    private function __construct($title, $link)
    {
        $this->title = (string) $title;
        $this->link  = is_null($link) ? null : (string) $link;
    }

    /**
     *
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     *
     * @return string
     */
    public function getLink()
    {
        if ($this->hasLink()) {
            return $this->link;
        }

        throw new \RuntimeException('No link defined.');
    }

    /**
     *
     *
     * @return bool
     */
    public function hasLink()
    {
        return (null !== $this->link);
    }
}
