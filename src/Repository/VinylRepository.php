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
//        $safeId = filter_var($id, FILTER_VALIDATE_INT);
        $qb = $this->conn->createQueryBuilder();
        $qb ->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->rightJoin('r', 'snipdata', 's', 'r.id=s.release_id')
            ->where('r.id = ?')
            ->setParameter(0, $id);

        $release = $qb->execute()->fetch();

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
    public function findEverything()
    {
        $qb = $this->conn->createQueryBuilder();
        $qb ->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipdata', 's', 'r.id=s.release_id');

        $releases = $qb->execute()->fetchAll();

        return $releases;
    }
    public function fillChoicesWithReleaseId()
    {
        $qb = $this->conn->createQueryBuilder();
        $qb ->select('id', 'title')
            ->from('releases', 'r');

        $choices = $qb->execute()->fetchAll(\PDO::FETCH_CLASS, 'VinylStore\\Entity\\ChoiceEntity');

        return $choices;
    }

    public function findLatestRelease()
    {
        $qb = $this->conn->createQueryBuilder();
        $qb ->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipdata', 's', 'r.id=s.release_id')
            ->orderBy('date_added', 'DESC LIMIT 4');

        $latestReleases = $qb->execute()->fetchAll();

        return $latestReleases;
    }
    public function findRandomRelease()
    {
        $qb = $this->conn->createQueryBuilder();
        $count = $this->conn->fetchColumn('SELECT COUNT(id) FROM releases');
        $randNum = rand(0, $count - 1);
//var_dump($count);
        $qb ->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
//            ->innerJoin('r', 'snipdata', 's', 'r.id=s.release_id')
            ->where('r.id', $randNum);
//            ->setMaxResults(1);

        $randomRelease = $qb->execute()->fetch();
//var_dump($randomRelease);
        return $randomRelease;
    }
}
