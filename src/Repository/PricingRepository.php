<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 28/02/2017
 * Time: 23:29.
 */

namespace VinylStore\Repository;

use Doctrine\Dbal\Connection;

class PricingRepository implements RepositoryInterface
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function save($data)
    {
        $count = $this->conn->insert('snipcart_data', $data);

        return $count;
    }
    public function findAll()
    {
        $stmt = $this->conn->prepare('SELECT * FROM snipcart_data');
        $stmt->execute();
        $priceData = $stmt->fetchAll();

        return $priceData;
    }
    public function findOneById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM snipcart_data WHERE id=:id');
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $priceData = $stmt->fetch();

        return $priceData;
    }
    public function deleteOneById($id)
    {
        $count = $this->conn->delete('snipcart_data', array('id' => $id));

        return $count;
    }
    public function getCount()
    {
        return $this->conn->fetchColumn('SELECT COUNT(id) FROM snipcart_data');
    }
}
