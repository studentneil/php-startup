<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 02/04/2017
 * Time: 21:32
 */

namespace VinylStoreTests;


use VinylStore\Repository\ImageRepository;


class ImageRepositoryTest extends VinylStoreDatabaseTest
{
    public function testRowCount()
    {
        $this->assertEquals(7, $this->getConnection()->getRowCount('images'));
    }
    public function testDeleteOneImage()
    {
        $numRowsAtStart = 7;
        $this->assertEquals($numRowsAtStart, $this->getConnection()->getRowCount('images'), 'Pre-Condition');
        $expectedRows = 6;
        $imageRepository = new ImageRepository($this->getDbal());
        $imageRepository->deleteOneById(4);
        $result = $this->getConnection()->getRowCount('images');
        $this->assertEquals($expectedRows, $result, 'rows at start: 7, deleted one and 6 rows remaining');
    }
}
