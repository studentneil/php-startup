<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 22/04/2017
 * Time: 21:28
 */

namespace VinylStoreTests;


use VinylStore\Repository\VinylRepository;


class VinylRepositoryTest extends VinylStoreDatabaseTest
{
    public function testRowCount()
    {
        $this->assertEquals(7, $this->getConnection()->getRowCount('releases'));
    }

    public function testLatestReleases()
    {
        $expectedResult = 4;
        $vinylRepository = new VinylRepository($this->getDbal());
        $result = $vinylRepository->findLatestRelease();
        $this->assertEquals($expectedResult, count($result), 'expected 4 results::actual results were 4');


    }
}
