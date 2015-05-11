<?php

namespace perf\Navigation;

/**
 *
 */
class PaginatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Provided item count must be greater or equal to 0.
     */
    public function testCreateWithInvalidItemCount()
    {
        $itemCount    = -1;
        $itemsPerPage = 8;
        $currentPage  = 1;

        Paginator::create($itemCount, $itemsPerPage, $currentPage);
    }

    /**
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Provided items per page must be greater or equal to 1.
     */
    public function testCreateWithInvalidItemsPerPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 0;
        $currentPage  = 1;

        Paginator::create($itemCount, $itemsPerPage, $currentPage);
    }

    /**
     *
     */
    public function testGetNextPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(6, $paginator->getNextPage());
    }

    /**
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No next page available.
     */
    public function testGetNextPageWithoutNextPageWillThrowException()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 12;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $paginator->getNextPage();
    }

    /**
     *
     */
    public function testHasNextPageReturnsTrue()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertTrue($paginator->hasNextPage());
    }

    /**
     *
     */
    public function testHasNextPageReturnsFalse()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 12;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertFalse($paginator->hasNextPage());
    }

    /**
     *
     */
    public function testGetPreviousPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(4, $paginator->getPreviousPage());
    }

    /**
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No previous page available.
     */
    public function testGetPreviousPageWithoutPreviousPageWillThrowException()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 1;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $paginator->getPreviousPage();
    }

    /**
     *
     */
    public function testGetFirstPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(1, $paginator->getFirstPage());
    }

    /**
     *
     */
    public function testGetLastPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(12, $paginator->getLastPage());
    }

    /**
     *
     */
    public function testGetItemCount()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame($itemCount, $paginator->getItemCount());
    }

    /**
     *
     */
    public function testGetItemsPerPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame($itemsPerPage, $paginator->getItemsPerPage());
    }

    /**
     *
     */
    public function testGetPageCount()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(12, $paginator->getPageCount());
    }

    /**
     *
     */
    public function testGetItemIndex()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(32, $paginator->getItemIndex());
    }

    /**
     *
     */
    public function testGetWithCurrentPageTooLowWillBeReplacedByFirstPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = -100;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame($paginator->getFirstPage(), $paginator->getCurrentPage());
    }

    /**
     *
     */
    public function testGetWithCurrentPageTooHighWillBeReplacedByLastPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 10000;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame($paginator->getLastPage(), $paginator->getCurrentPage());
    }
}
