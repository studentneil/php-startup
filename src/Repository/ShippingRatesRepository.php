<?php

namespace VinylStore\Repository;

class ShippingRatesRepository extends AbstractRepository
{
    const TABLE = 'shipping_rates';

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
        $stmt = $this->connection->prepare('SELECT cost, description FROM shipping_rates');
        $stmt->execute();
        $priceData = $stmt->fetchAll();

        return $priceData;
    }

    public function viewAll()
    {
        $stmt = $this->connection->prepare('SELECT * FROM shipping_rates');
        $stmt->execute();
        $ratesData = $stmt->fetchAll();

        return $ratesData;
    }

    public function findOneById($quantity)
    {
        $stmt = $this->connection->prepare('SELECT cost, description FROM shipping_rates WHERE quantity=:quantity');
        $stmt->bindValue('quantity', $quantity);
        $stmt->execute();
        $priceData = $stmt->fetch();

        return $priceData;
    }

    public function deleteOneById($id)
    {
        $safeId = trim(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $count = $this->connection->delete('shipping_rates', array('id' => $safeId));

        return $count;
    }

    public function getCount()
    {
        return $this->connection->fetchColumn('SELECT COUNT(id) FROM shipping_rates');
    }

    public function editRates(array $ratesData, $id)
    {
        $safeId = trim(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $count = $this->connection->update('shipping_rates', $ratesData, array('id' => $safeId));

        return $count;
    }
}