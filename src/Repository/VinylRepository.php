<?php

namespace VinylStore\Repository;

use Doctrine\Dbal\Connection;

class VinylRepository implements RepositoryInterface
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }
    public function save(array $array)
    {
        $count = $this->conn->insert('exhibition', $arr);

        return $count;
    }
    public function findAll()
    {
        $stmt = $this->conn->prepare('SELECT * FROM collection');
        $stmt->execute();
        $collection = $stmt->fetchAll();

        return $collection;
    }
    public function findOneById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM collection WHERE id=:id');
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $release = $stmt->fetch();

        return $release;
    }
    public function deleteOneById($id)
    {
        $count = $this->conn->delete('collection', array('id' => $id));

        return $count;
    }
    public function getCount()
    {
        return $this->conn->fetchColumn('SELECT COUNT(id) FROM collection');
    }
}
