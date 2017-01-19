<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 10/01/2017
 * Time: 23:05
 */

namespace VinylStore\Repository;
use Doctrine\Dbal\Connection;

class ImageRepository implements RepositoryInterface
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }
    public function save($file)
    {

        $uploadedImage = array(
            'image' => $file->getImage(),
            'name' => $file->getName(),
            'release_id' => $file->getReleaseId(),
        );

        $count = $this->conn->insert('images', $uploadedImage);

        return $count;
    }
    public function findAll()
    {
        $stmt = $this->conn->prepare('SELECT * FROM images');
        $stmt->execute();
        $images = $stmt->fetchAll();

        return $images;
    }
    public function findOneById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM images WHERE id=:id');
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $image = $stmt->fetch();

        return $image;
    }
    public function deleteOneById($id)
    {
        $count = $this->conn->delete('images', array('id' => $id));

        return $count;
    }
    public function getCount()
    {
        return $this->conn->fetchColumn('SELECT COUNT(id) FROM images');
    }

    public function getImageNameForDelete($id)
    {
        $image = $this->conn->fetchColumn('SELECT image FROM images WHERE id = ?', array($id));


        return $image;
    }
    public function attachImageToRelease($imageId, $releaseId)
    {
        $count = $this->conn->executeUpdate('UPDATE images SET release_id = ? WHERE id = ?', array($releaseId, $imageId));

        return $count;
    }
}