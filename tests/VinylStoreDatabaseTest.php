<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 29/03/2017
 * Time: 23:36
 */

namespace VinylStoreTests;
use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;



class VinylStoreDatabaseTest extends TestCase
{
    use TestCaseTrait;
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

}


