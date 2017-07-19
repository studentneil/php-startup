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
        $qb = $this->joinAll();
        $qb->where('r.id = ?')
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

    public function getActiveReleasesCount()
    {
        return $this->conn->fetchColumn('SELECT COUNT(id) FROM releases WHERE quantity >= 1');
    }

    public function getActiveReleaseByGenre($genre)
    {
        $stmt = $this->conn->prepare('SELECT COUNT(id) FROM releases WHERE genre=:genre');
        $stmt->bindValue('genre', $genre);
        $stmt->execute();

        return $total = $stmt->fetchColumn();

    }

    public function joinAll()
    {
        $qb = $this->conn->createQueryBuilder();
        $qb->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipcart_data', 's', 'r.id=s.release_id');

        return $qb;
    }

    public function findEverything()
    {
        $qb = $this->joinAll();
        $qb->andHaving('quantity >= 1');
        $releases = $qb->execute()->fetchAll();

        return $releases;
    }

    public function getReleasesByGenre($genre, $limit, $offset)
    {
        $qb = $this->joinAll();
        $qb->setFirstResult($offset)
            ->setMaxResults($limit)
            ->andWhere('genre = ?')
            ->andHaving('quantity >= 1')
            ->setParameter(0, $genre);
        $genreReleases = $qb->execute()->fetchAll();

        return $genreReleases;
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
        $qb = $this->joinAll();
        $qb->orderBy('date_added', 'DESC LIMIT 6')
            ->andHaving('quantity >= 1');

        $latestReleases = $qb->execute()->fetchAll();

        return $latestReleases;
    }

    public function findRandomRelease()
    {
        $stmt = $this->conn->prepare('SELECT * FROM releases INNER JOIN images ON releases.id=images.release_id INNER JOIN snipcart_data ON releases.id=snipcart_data.release_id AND releases
.quantity >= 1 ORDER BY 
RAND() 
LIMIT 1 ');
        $stmt->execute();
        $randomRelease = $stmt->fetchAll();

        return $randomRelease;
    }

    public function findForPagination($limit, $offset = 0)
    {
        $qb = $this->joinAll();
        $qb->setFirstResult($offset)
            ->setMaxResults($limit)
            ->andHaving('quantity >= 1');

        $paginatedReleases = $qb->execute()->fetchAll();

        return $paginatedReleases;
    }
    public function paginate($limit, $offset)
    {
        $qb = $this->conn->createQueryBuilder();
        $qb->setFirstResult($offset)
            ->setMaxResults($limit)
            ->andHaving('quantity >= 1');
        $paginatedReleases = $qb->execute()->fetchAll();
        return $paginatedReleases;
    }

    public function refine(array $refineFormData)
    {
        $genreArr = array();
        $formatArr = array();
        $qb = $this->conn->createQueryBuilder();
        $qb->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipcart_data', 's', 'r.id=s.release_id');
        if (!empty($refineFormData['genre'])) {
            foreach ($refineFormData['genre'] as $x => $genre) {
                $genreArr[] = $genre;
                $qb->orWhere('genre = ?');
            }
        }
        if (!empty($refineFormData['format'])) {
            foreach ($refineFormData['format'] as $y => $format) {
                $formatArr[] = $format;
                $qb->orHaving('format = ?');
            }
        }

        $dataArr = array_merge($genreArr, $formatArr);
        if (!empty($dataArr)) {
            $qb->setParameters($dataArr);
        }
//        var_dump($qb->getSQL());
        $qb->andHaving('quantity >= 1');
        $refinedResults = $qb->execute()->fetchAll();

        return $refinedResults;
    }
    public function findReleaseForEdit($id)
    {
        //        $safeId = filter_var($id, FILTER_VALIDATE_INT);
        $qb = $this->conn->createQueryBuilder();
        $qb->select('*')
            ->from('releases', 'r')
            ->where('r.id = ?')
            ->setParameter(0, $id);

        $release = $qb->execute()->fetch();

        return $release;
    }

    public function editRelease(array $releaseData, $id)
    {
        $count = $this->conn->update('releases', $releaseData, array('id' => $id));

        return $count;
    }

    public function orderCompleted($id)
    {
        $count = $this->conn->executeUpdate('UPDATE releases SET quantity = quantity-1 WHERE id = ?', array($id));

        return $count;
    }
}
