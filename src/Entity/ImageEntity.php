<?php

namespace VinylStore\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageEntity
{
    private $image;

    /** @var int */
    private $release_id;

    /** @var string */
    private $imagePath;

    /**
     *@return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getReleaseId()
    {
        return $this->release_id;
    }

    /**
     * @param int $release_id
     */
    public function setReleaseId(int $release_id)
    {
        $this->release_id = $release_id;
    }

    /**
     * @param string $path
     * @return string
     */
    public function setImagePath($path)
    {
        $imagePath = 'uploads/'.$path;

        return $imagePath;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }
}
