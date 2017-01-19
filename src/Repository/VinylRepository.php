<?php

namespace VinylStore\Repository;

use Doctrine\Dbal\Connection;
use VinylStore\Entity\ChoiceEntity;

class VinylRepository implements RepositoryInterface
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }
    public function save($release)
    {
        $count = $this->conn->insert('releases', $release);

        return $count;
    }
    public function findAll()
    {
        $stmt = $this->conn->prepare('SELECT * FROM releases');
        $stmt->execute();
        $collection = $stmt->fetchAll();

        return $collection;
    }
    public function findOneById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM releases WHERE id=:id');
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $release = $stmt->fetch();

        return $release;
    }
    public function deleteOneById($id)
    {
        $count = $this->conn->delete('releases', array('id' => $id));

        return $count;
    }
    public function getCount()
    {
        return $this->conn->fetchColumn('SELECT COUNT(id) FROM releases');
    }
    public function findAllWithImages()
    {
        $qb = $this->conn->createQueryBuilder();
        $qb ->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id');

        $releases = $qb->execute()->fetchAll();

        return $releases;
    }
    public function fillChoicesWithReleaseId()
    {
        $qb = $this->conn->createQueryBuilder();
        $qb ->select('id', 'title')
            ->from('releases', 'r')
            ->where('r.image_id IS NULL');
        $choices = $qb->execute()->fetchAll(\PDO::FETCH_OBJ);

        return $choices;
    }
}
