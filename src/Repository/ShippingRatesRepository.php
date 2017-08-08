<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 12/06/2017
 * Time: 22:25
 */

namespace VinylStore\Repository;
use Doctrine\Dbal\Connection;

class ShippingRatesRepository implements RepositoryInterface
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function save($data)
    {
        $count = $this->conn->insert('shipping_rates', $data);

        return $count;
    }
    public function findAll()
    {
        $stmt = $this->conn->prepare('SELECT cost, description FROM shipping_rates');
        $stmt->execute();
        $priceData = $stmt->fetchAll();

        return $priceData;
    }

    public function viewAll()
    {
        $stmt = $this->conn->prepare('SELECT * FROM shipping_rates');
        $stmt->execute();
        $ratesData = $stmt->fetchAll();

        return $ratesData;
    }

    public function findOneById($quantity)
    {
        $stmt = $this->conn->prepare('SELECT cost, description FROM shipping_rates WHERE quantity=:quantity');
        $stmt->bindValue('quantity', $quantity);
        $stmt->execute();
        $priceData = $stmt->fetch();

        return $priceData;
    }

    public function deleteOneById($id)
    {
        $safeId = trim(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $count = $this->conn->delete('shipping_rates', array('id' => $safeId));

        return $count;
    }

    public function getCount()
    {
        return $this->conn->fetchColumn('SELECT COUNT(id) FROM shipping_rates');
    }

    public function editRates(array $ratesData, $id)
    {
        $safeId = trim(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $count = $this->conn->update('shipping_rates', $ratesData, array('id' => $safeId));

        return $count;
    }
}