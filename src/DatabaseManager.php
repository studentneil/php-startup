<?php

namespace VinylStore;

use Silex\Application;
use Doctrine\DBAL\Connection;

Class DatabaseManager
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getTables()
    {
        $sm = $this->conn->getSchemaManager();
        $tables= $sm->listTableNames();

        return $tables;
    }

    public function viewTable($table)
    {
        $stmt = $this->conn->fetchAll('SELECT * FROM '.$this->conn->quoteIdentifier($table));

        return $stmt;
    }

    public function viewColumnNames($table)
    {
        $sm = $this->conn->getSchemaManager();
        $columns = $sm->listTableColumns($table);
        $names = array();
        foreach ($columns as $column) {
            $name = $column->getName();
            array_push($names, $name);
        }
        return $names;
    }
}
