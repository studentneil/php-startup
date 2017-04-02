<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 29/03/2017
 * Time: 23:36
 */

namespace VinylStoreTests;
use Doctrine\DBAL\DriverManager;
use VinylStore\Repository\ImageRepository;


class VinylStoreDatabaseTest extends \PHPUnit_Extensions_Database_TestCase
{
    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;
    static private $dbal = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new \PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS']);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_NAME']);
        }

        return $this->conn;
    }
    protected function getPdo()
    {
        return $this->getConnection()->getConnection();
    }
    protected function getDbal()
    {
        if (self::$dbal === null)
        {
            self::$dbal = DriverManager::getConnection(array('pdo' => $this->getPdo()));
        }

        return self::$dbal;
    }
    protected function getDataSet()
    {
        return $this->createXMLDataset(__DIR__.'/datasetXml/seed.xml');
    }
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

//    public function getDataSet()
//    {
//        $seedFilePath = __DIR__ . '/databaseXml/seed.xml';
//        return $this->createXMLDataSet($seedFilePath);
//    }
//
//    public function testDatasetMatchesSelectQuery()
//    {
//        $queryTable = $this->getConnection()->createQueryTable(
//            'images', 'SELECT * FROM images'
//        );
//        $expectedTable = $this->createFlatXmlDataSet("seed.xml")
//                              ->getTable("images");
//        $this->assertTablesEqual($expectedTable, $queryTable);
//    }

