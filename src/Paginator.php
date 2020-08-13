<?php

namespace perf\Navigation;

use InvalidArgumentException;
use perf\Navigation\Exception\PaginationException;
use RuntimeException;

/**
 * This class helps computing the different page indexes (first, previous, next, etc.) related to pagination.
 */
class Paginator
{
    private const FIRST_PAGE_DEFAULT = 1;

    /**
     * Total number of items to paginate.
     */
    private int $itemCount;

    /**
     * Number of items to be shown per page.
     */
    private int $itemsPerPage;

    /**
     * Index of the current page.
     */
    private int $currentPage;

    /**
     * Total number of pages.
     */
    private int $pageCount;

    /**
     * Index of the first page.
     */
    private int $firstPage;

    /**
     * Index of the last page.
     */
    private int $lastPage;

    /**
     * Index of the previous page, if any.
     */
    private ?int $previousPage;

    /**
     * Index of the next page, if any.
     */
    private ?int $nextPage;

    /**
     * @param int $itemCount    Total number of items to paginate.
     * @param int $itemsPerPage Number of items to be shown per page.
     * @param int $currentPage  Index of the current page.
     * @param int $firstPage    Index of the first page.
     *
     * @return Paginator
     *
     * @throws PaginationException
     */
    public static function create($itemCount, $itemsPerPage, $currentPage, $firstPage = self::FIRST_PAGE_DEFAULT): self
    {
        return new self($itemCount, $itemsPerPage, $currentPage, $firstPage);
    }

    /**
     * @param int $itemCount    Total number of items to paginate.
     * @param int $itemsPerPage Number of items to be shown per page.
     * @param int $currentPage  Index of the current page.
     * @param int $firstPage    Index of the first page.
     *
     * @throws PaginationException
     */
    private function __construct(int $itemCount, int $itemsPerPage, int $currentPage, int $firstPage)
    {
        if ($itemCount < 0) {
            throw new PaginationException("Provided item count must be greater or equal to 0.");
        }

        if ($itemsPerPage < 1) {
            throw new PaginationException("Provided items per page must be greater or equal to 1.");
        }

        $this->itemCount    = $itemCount;
        $this->itemsPerPage = $itemsPerPage;
        $this->pageCount    = max(1, (int) ceil($this->itemCount / $this->itemsPerPage));
        $this->firstPage    = $firstPage;
        $this->lastPage     = ($this->firstPage + $this->pageCount - 1);

        $this->setCurrentPage($currentPage);
    }

    /**
     * Alters the value of current page index.
     *
     * @param int $currentPage Current page.
     *
     * @return Paginator Fluent return.
     */
    public function setCurrentPage(int $currentPage): self
    {
        $currentPage = $this->fixPage($currentPage);

        $this->currentPage  = $currentPage;
        $this->previousPage = null;
        $this->nextPage     = null;

        if ($this->currentPage > $this->firstPage) {
            $this->previousPage = ($this->currentPage - 1);
        }

        if ($this->currentPage < $this->lastPage) {
            $this->nextPage = ($this->currentPage + 1);
        }

        return $this;
    }

    private function fixPage(int $page): int
    {
        if ($page < $this->firstPage) {
            return $this->firstPage;
        }

        if ($page > $this->lastPage) {
            return $this->lastPage;
        }

        return $page;
    }

    public function getItemCount(): int
    {
        return $this->itemCount;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getFirstPage(): int
    {
        return $this->firstPage;
    }

    /**
     * Returns the index of the previous page.
     *
     * @return int
     *
     * @throws PaginationException
     */
    public function getPreviousPage(): int
    {
        if ($this->hasPreviousPage()) {
            return $this->previousPage;
        }

        throw new PaginationException('No previous page available.');
    }

    public function hasPreviousPage(): bool
    {
        return (null !== $this->previousPage);
    }

    /**
     * Returns the index of the next page.
     *
     * @return int
     *
     * @throws PaginationException
     */
    public function getNextPage(): int
    {
        if ($this->hasNextPage()) {
            return $this->nextPage;
        }

        throw new PaginationException('No next page available.');
    }

    public function hasNextPage(): bool
    {
        return (null !== $this->nextPage);
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * Returns the index of the first item in the current page (may be useful to compute a SQL LIMIT clause).
     *
     * @return int
     */
    public function getItemIndex(): int
    {
        return (($this->currentPage - $this->firstPage) * $this->itemsPerPage);
    }
}
