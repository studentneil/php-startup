<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 08/08/2017
 * Time: 22:31
 */

namespace VinylStoreTests;


use VinylStore\Paginator;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    public function testPaginatorContructor()
    {
        $numpages = 4;
        $pager = new Paginator(5, 20);
        $this->assertEquals($numpages, $pager->getNumPages());
    }

    public function testGetOffsetWithCorrectParameters()
    {
        $offset = 30;

        $pager = new Paginator(5, 20);
        $pager->setLimit(10);
        $pager->setCurrentPage(4);
        $this->assertEquals($offset, $pager->getOffset());
    }
}
