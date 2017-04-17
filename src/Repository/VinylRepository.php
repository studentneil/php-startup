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
        $qb->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->rightJoin('r', 'snipcart_data', 's', 'r.id=s.release_id')
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
        $qb->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipcart_data', 's', 'r.id=s.release_id');

        $releases = $qb->execute()->fetchAll();

        return $releases;
    }
    public function fillChoicesWithReleaseId()
    {
        $qb = $this->conn->createQueryBuilder();
        $qb->select('id', 'title')
            ->from('releases', 'r');

        $choices = $qb->execute()->fetchAll(\PDO::FETCH_CLASS, 'VinylStore\\Entity\\ChoiceEntity');

        return $choices;
    }

    public function findLatestRelease()
    {
        $qb = $this->conn->createQueryBuilder();
        $qb->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipcart_data', 's', 'r.id=s.release_id')
            ->orderBy('date_added', 'DESC LIMIT 4')
            ->andHaving('quantity >= 1');

        $latestReleases = $qb->execute()->fetchAll();

        return $latestReleases;
    }
    public function findRandomRelease()
    {
        $stmt = $this->conn->prepare('SELECT * FROM releases INNER JOIN images ON releases.id=images.release_id ORDER BY RAND() LIMIT 4');
        $stmt->execute();
        $randomRelease = $stmt->fetchAll();

        return $randomRelease;
    }
    public function findForPagination($limit, $offset = 0)
    {
        $qb = $this->conn->createQueryBuilder();
        $qb->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipcart_data', 's', 'r.id=s.release_id')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
//            ->orderBy('date_added', 'DESC')
            ->andHaving('quantity >= 1');

        $paginatedReleases = $qb->execute()->fetchAll();

        return $paginatedReleases;
    }
    public function refine($data)
    {
        $qb = $this->conn->createQueryBuilder();
        $qb->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipcart_data', 's', 'r.id=s.release_id');
            if ($data['genre']) {
                $qb->where('genre = :genre')
                    ->setParameter(':genre', $data['genre'][0]);
            }

          if ($data['format']) {
              $qb->andWhere('format = :format')
                  ->setParameter(':format', $data['format'][0]);
          }

        $refinedResults = $qb->execute()->fetchAll();

        return $refinedResults;

    }
}
