<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 11/01/2017
 * Time: 23:19.
 */

namespace VinylStore;

use VinylStore\Entity\ImageEntity;

class ImageUploader
{

    /** @var string */
    private $targetDir;

    /** @var string */
    private $fileName;

    public function __construct(string $targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * @param \VinylStore\Entity\ImageEntity $image
     * @return string|\VinylStore\Entity\ImageEntity
     */
    public function upload(ImageEntity $image)
    {
//        get the actual image from the file entity
//        and create a unique name
        $imageFile = $image->getImage();

        $this->fileName = md5(uniqid()).'.'.$imageFile->guessExtension();
//        check if the file exists
        if (file_exists($this->targetDir.'/'.$this->fileName)) {
            return MessageService::IMAGE_ALREADY_EXISTS;
        }
//        set the unique name on the image
        $image->setImage($this->fileName);
//        try to move the file to the directory passed in the constructor
        if (!$imageFile->move($this->getTargetDir().'/', $this->getFileName())) {
            return MessageService::IMAGE_UPLOAD_FAILURE;
        }

        return $image;
    }

    /**
     * @return string
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
