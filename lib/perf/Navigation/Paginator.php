<?php

namespace perf\Navigation;

use perf\TypeValidation\Type;

/**
 * This class helps computing the different page indexes (first, previous, next, etc.) related to pagination.
 *
 */
class Paginator
{

    const FIRST_PAGE_DEFAULT = 1;

    /**
     * Total number of items to paginate.
     *
     * @var int
     */
    private $itemCount;

    /**
     * Number of items to be shown per page.
     *
     * @var int
     */
    private $itemsPerPage;

    /**
     * Index of the current page.
     *
     * @var int
     */
    private $currentPage;

    /**
     * Total number of pages.
     *
     * @var int
     */
    private $pageCount;

    /**
     * Index of the first page.
     *
     * @var int
     */
    private $firstPage;

    /**
     * Index of the last page.
     *
     * @var int
     */
    private $lastPage;

    /**
     * Index of the previous page, if any.
     *
     * @var null|int
     */
    private $previousPage;

    /**
     * Index of the next page, if any.
     *
     * @var null|int
     */
    private $nextPage;

    /**
     * Static constructor.
     *
     * @param int $itemCount Total number of items to paginate.
     * @param int $itemsPerPage Number of items to be shown per page.
     * @param int $currentPage Index of the current page.
     * @param int $firstPage Index of the first page.
     * @return Paginator
     * @throws \InvalidArgumentException
     */
    public static function create($itemCount, $itemsPerPage, $currentPage, $firstPage = self::FIRST_PAGE_DEFAULT)
    {
        return new self($itemCount, $itemsPerPage, $currentPage, $firstPage);
    }

    /**
     * Constructor.
     *
     * @param int $itemCount Total number of items to paginate.
     * @param int $itemsPerPage Number of items to be shown per page.
     * @param int $currentPage Index of the current page.
     * @param int $firstPage Index of the first page.
     * @return void
     * @throws \InvalidArgumentException
     */
    private function __construct($itemCount, $itemsPerPage, $currentPage, $firstPage)
    {
        Type::mustBe('int', $itemCount, 'item count');
        Type::mustBe('int', $itemsPerPage, 'items per page');
        Type::mustBe('int', $firstPage, 'first page');

        if ($itemCount < 0) {
            throw new \InvalidArgumentException("Provided item count must be greater or equal to 0.");
        }

        if ($itemsPerPage < 1) {
            throw new \InvalidArgumentException("Provided items per page must be greater or equal to 1.");
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
     * @return Paginator Fluent return.
     * @throws \InvalidArgumentException
     */
    public function setCurrentPage($currentPage)
    {
        Type::mustBe('int', $currentPage, 'current page');

        $currentPage = $this->fixPage($currentPage);

        $this->currentPage = $currentPage;

        if ($this->currentPage > $this->firstPage) {
            $this->previousPage = ($this->currentPage - 1);
        } else {
            $this->previousPage = null;
        }

        if ($this->currentPage < $this->lastPage) {
            $this->nextPage = ($this->currentPage + 1);
        } else {
            $this->nextPage = null;
        }

        return $this;
    }

    /**
     *
     *
     * @param int $page
     * @return int
     */
    private function fixPage($page)
    {
        if ($page < $this->firstPage) {
            return $this->firstPage;
        }

        if ($page > $this->lastPage) {
            return $this->lastPage;
        }

        return $page;
    }

    /**
     * Returns the total number of items to paginate.
     *
     * @return int
     */
    public function getItemCount()
    {
        return $this->itemCount;
    }

    /**
     * Returns the number of items to be shown per page.
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * Returns the total number of pages.
     *
     * @return int
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * Returns the index of the current page.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Returns the index of the first page.
     *
     * @return int
     */
    public function getFirstPage()
    {
        return $this->firstPage;
    }

    /**
     * Returns the index of the previous page.
     *
     * @return int
     * @throws \RuntimeException
     */
    public function getPreviousPage()
    {
        if ($this->hasPreviousPage()) {
            return $this->previousPage;
        }

        throw new \RuntimeException('No previous page available.');
    }

    /**
     * Returns true if a previous page exists (ie, if current page is not the first page).
     *
     * @return bool
     */
    public function hasPreviousPage()
    {
        return (null !== $this->previousPage);
    }

    /**
     * Returns the index of the next page (may be equal to current page index, if current page is the last page).
     *
     * @return int
     * @throws \RuntimeException
     */
    public function getNextPage()
    {
        if ($this->hasNextPage()) {
            return $this->nextPage;
        }

        throw new \RuntimeException('No next page available.');
    }

    /**
     * Returns true if a next page exists (ie, if current page is not the last page).
     *
     * @return bool
     */
    public function hasNextPage()
    {
        return (null !== $this->nextPage);
    }

    /**
     * Returns the index of the last page.
     *
     * @return int
     */
    public function getLastPage()
    {
        return $this->lastPage;
    }

    /**
     * Returns the index of the first item in the current page (may be useful to compute a SQL LIMIT clause).
     *
     * @return int
     */
    public function getItemIndex()
    {
        return (($this->currentPage - $this->firstPage) * $this->itemsPerPage);
    }
}
