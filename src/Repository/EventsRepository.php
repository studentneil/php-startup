<?php

namespace VinylStore\Repository;

use Doctrine\DBAL\DBALException;

class EventsRepository extends AbstractRepository
{
    const TABLE = 'events';

    /**
     * @param array $data
     * @return int
     */
    public function save($data)
    {
        $count = $this->connection->insert(self::TABLE, $data);

        return $count;
    }

    public function findAll()
    {
        $stmt = $this->connection->prepare('SELECT * FROM events');
        $stmt->execute();
        $events = $stmt->fetchAll();

        return $events;
    }

    /**
     * @param int $id
     * @return bool|array
     */
    public function findOneById($id)
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM events WHERE release_id=:id');
            $stmt->bindValue('id', $id);
            $stmt->execute();
            $eventData = $stmt->fetch();
        } catch (DBALException $e) {
            $eventData = false;
        }

        return $eventData;
    }
    public function deleteOneById($id)
    {
        $count = $this->connection->delete('events', array('id' => $id));

        return $count;
    }
    public function getCount()
    {
        return $this->connection->fetchColumn('SELECT COUNT(id) FROM events');
    }
}