<?php

namespace perf\Navigation;

use DomainException;
use perf\Navigation\Exception\BreadcrumbsException;
use RuntimeException;

class BreadcrumbsNode
{
    private string $title;

    private ?string $link;

    private array $attributes = [];

    public static function create(string $title, ?string $link = null, array $attributes = []): self
    {
        return new self($title, $link, $attributes);
    }

    private function __construct(string $title, ?string $link, array $attributes)
    {
        $this->title      = $title;
        $this->link       = $link;
        $this->attributes = $attributes;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     *
     * @throws BreadcrumbsException
     */
    public function getLink(): string
    {
        if ($this->hasLink()) {
            return $this->link;
        }

        throw new BreadcrumbsException('No link defined.');
    }

    public function hasLink(): bool
    {
        return (null !== $this->link);
    }

    /**
     * @param string $attribute
     *
     * @return mixed
     *
     * @throws BreadcrumbsException
     */
    public function getAttribute(string $attribute)
    {
        if ($this->hasAttribute($attribute)) {
            return $this->attributes[$attribute];
        }

        throw new BreadcrumbsException("Attribute '{$attribute}' not defined.");
    }

    public function hasAttribute(string $attribute): bool
    {
        return array_key_exists($attribute, $this->attributes);
    }
}
