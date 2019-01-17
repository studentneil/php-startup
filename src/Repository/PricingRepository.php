<?php

namespace VinylStore\Repository;

class PricingRepository extends AbstractRepository
{
    const TABLE = 'snipcart_data';

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
        $stmt = $this->connection->prepare('SELECT * FROM snipcart_data');
        $stmt->execute();
        $priceData = $stmt->fetchAll();

        return $priceData;
    }
    public function findOneById($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM snipcart_data WHERE release_id=:id');
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $priceData = $stmt->fetch();

        return $priceData;
    }
    public function deleteOneById($id)
    {
        $count = $this->connection->delete('snipcart_data', array('id' => $id));

        return $count;
    }
    public function getCount()
    {
        return $this->connection->fetchColumn('SELECT COUNT(id) FROM snipcart_data');
    }

    public function editPricing(array $pricingData, $id)
    {
        $count = $this->connection->update('snipcart_data', $pricingData, array('release_id' => $id));

        return $count;
    }
}
