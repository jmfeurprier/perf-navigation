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
     *
     *
     * @var {string:mixed}
     */
    private $attributes = array();

    /**
     * Static constructor.
     *
     * @param string $title
     * @param null|string $link
     * @param {string:mixed} $attributes
     * @return BreadcrumbsNode
     */
    public static function create($title, $link = null, array $attributes = array())
    {
        return new self($title, $link, $attributes);
    }

    /**
     * Constructor.
     *
     * @param string $title
     * @param null|string $link
     * @param {string:mixed} $attributes
     * @return void
     */
    private function __construct($title, $link, array $attributes)
    {
        $this->title      = (string) $title;
        $this->link       = is_null($link) ? null : (string) $link;
        $this->attributes = $attributes;
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
     * @throws \RuntimeException
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

    /**
     *
     *
     * @return mixed
     * @throws \DomainException
     */
    public function getAttribute($attribute)
    {
        if ($this->hasAttribute($attribute)) {
            return $this->attributes[$attribute];
        }

        throw new \DomainException("Attribute '{$attribute}' not defined.");
    }

    /**
     *
     *
     * @return bool
     */
    public function hasAttribute($attribute)
    {
        return array_key_exists($attribute, $this->attributes);
    }
}
