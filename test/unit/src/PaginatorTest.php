<?php

namespace perf\Navigation;

use perf\Navigation\Exception\PaginationException;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    public function testCreateWithInvalidItemCount()
    {
        $itemCount    = -1;
        $itemsPerPage = 8;
        $currentPage  = 1;

        $this->expectException(PaginationException::class);
        $this->expectExceptionMessage("Provided item count must be greater or equal to 0.");

        Paginator::create($itemCount, $itemsPerPage, $currentPage);
    }

    public function testCreateWithInvalidItemsPerPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 0;
        $currentPage  = 1;

        $this->expectException(PaginationException::class);
        $this->expectExceptionMessage("Provided items per page must be greater or equal to 1.");

        Paginator::create($itemCount, $itemsPerPage, $currentPage);
    }

    public function testGetNextPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(6, $paginator->getNextPage());
    }

    public function testGetNextPageWithoutNextPageWillThrowException()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 12;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->expectException(PaginationException::class);
        $this->expectExceptionMessage("No next page available.");

        $paginator->getNextPage();
    }

    public function testHasNextPageReturnsTrue()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertTrue($paginator->hasNextPage());
    }

    public function testHasNextPageReturnsFalse()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 12;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertFalse($paginator->hasNextPage());
    }

    public function testGetPreviousPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(4, $paginator->getPreviousPage());
    }

    public function testGetPreviousPageWithoutPreviousPageWillThrowException()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 1;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->expectException(PaginationException::class);
        $this->expectExceptionMessage("No previous page available.");

        $paginator->getPreviousPage();
    }

    public function testGetFirstPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(1, $paginator->getFirstPage());
    }

    public function testGetLastPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(12, $paginator->getLastPage());
    }

    public function testGetItemCount()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame($itemCount, $paginator->getItemCount());
    }

    public function testGetItemsPerPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame($itemsPerPage, $paginator->getItemsPerPage());
    }

    public function testGetPageCount()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(12, $paginator->getPageCount());
    }

    public function testGetItemIndex()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 5;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame(32, $paginator->getItemIndex());
    }

    public function testGetWithCurrentPageTooLowWillBeReplacedByFirstPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = -100;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame($paginator->getFirstPage(), $paginator->getCurrentPage());
    }

    public function testGetWithCurrentPageTooHighWillBeReplacedByLastPage()
    {
        $itemCount    = 95;
        $itemsPerPage = 8;
        $currentPage  = 10000;

        $paginator = Paginator::create($itemCount, $itemsPerPage, $currentPage);

        $this->assertSame($paginator->getLastPage(), $paginator->getCurrentPage());
    }
}
