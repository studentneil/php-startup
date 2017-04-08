<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 11/01/2017
 * Time: 21:52.
 */

namespace VinylStore\Entity;

class ImageEntity
{
    private $image;
    private $name;
    private $release_id;
    private $imagePath;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getReleaseId()
    {
        return $this->release_id;
    }

    /**
     * @param mixed $release_id
     */
    public function setReleaseId($release_id)
    {
        $this->release_id = $release_id;
    }

    /**
     * @param $path
     * @return string
     */
    public function setImagePath($path)
    {
        $imagePath = 'uploads/'.$path;

        return $imagePath;
    }
    public function getImagePath()
    {
        return $this->imagePath;
    }
}
