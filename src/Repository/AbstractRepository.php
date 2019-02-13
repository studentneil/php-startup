<?php

namespace VinylStore\Repository;

use Doctrine\DBAL\Connection;
use VinylStore\Entity\EntityInterface;

abstract class AbstractRepository
{
    const TABLE = '';

    /** @var Connection */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    abstract public function save($data);

    abstract public function findOneById($id);

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function findAll()
    {
        $stmt = $this->connection->prepare(sprintf('SELECT * FROM %s', self::TABLE));
        $stmt->execute();
        $collection = $stmt->fetchAll();

        return $collection;
    }

    /**
     * @param int $id
     * @return int
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    protected function deleteOneById($id)
    {
        $count = $this->connection->delete(self::TABLE, array('id' => $id));

        return $count;
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    protected function joinAll()
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')
            ->from('releases', 'r')
            ->innerJoin('r', 'images', 'i', 'r.id=i.release_id')
            ->innerJoin('r', 'snipcart_data', 's', 'r.id=s.release_id');

        return $qb;
    }
}