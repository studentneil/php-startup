<?php

namespace VinylStore\Repository;

class ImageRepository extends AbstractRepository
{

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return int
     */
    public function save($file)
    {
        $uploadedImage = array(
            'image' => $file->getImage(),
            'release_id' => $file->getReleaseId(),
        );

        $count = $this->connection->insert('images', $uploadedImage);

        return $count;
    }

    public function findAll()
    {
        $stmt = $this->connection->prepare('SELECT * FROM images ORDER BY "date_added" DESC');
        $stmt->execute();
        $images = $stmt->fetchAll();

        return $images;
    }

    public function findOneById($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM images WHERE id=:id');
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $image = $stmt->fetch();

        return $image;
    }

    public function deleteOneById($id)
    {
        $count = $this->connection->delete('images', array('image_id' => $id));

        return $count;
    }

    public function getCount()
    {
        return $this->connection->fetchColumn('SELECT COUNT(id) FROM images');
    }

    public function getImageNameForDelete($id)
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')
            ->from('images', 'i')
            ->where('i.image_id = ?')
            ->setParameter(0, $id);

        $image = $qb->execute()->fetchObject('VinylStore\\Entity\\ImageEntity');

        return $image;
    }

    public function attachImageToRelease($imageId, $releaseId)
    {
        $count = $this->connection->executeUpdate('UPDATE images SET release_id = ? WHERE id = ?', array($releaseId, $imageId));

        return $count;
    }
}
