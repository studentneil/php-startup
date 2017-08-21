<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 20/08/2017
 * Time: 22:58
 */

namespace VinylStore\Repository;

use Doctrine\Dbal\Connection;

class EventsRepository implements RepositoryInterface
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }
    public function findAll()
    {
        $stmt = $this->conn->prepare('SELECT * FROM events');
        $stmt->execute();
        $events = $stmt->fetchAll();

        return $events;
    }
    public function save($data)
    {
        $count = $this->conn->insert('events', $data);

        return $count;
    }
    public function findOneById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM events WHERE release_id=:id');
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $eventData = $stmt->fetch();

        return $eventData;
    }
    public function deleteOneById($id)
    {
        $count = $this->conn->delete('events', array('id' => $id));

        return $count;
    }
    public function getCount()
    {
        return $this->conn->fetchColumn('SELECT COUNT(id) FROM events');
    }
}