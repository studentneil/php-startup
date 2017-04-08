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
    private $targetDir;
    private $fileName;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(ImageEntity $image)
    {
        //        no file, return with error message
        if (!$image) {
            return BoolFlag::IMAGE_UPLOAD_FAILURE;
        }
//        get the actual image from the file entity
//        and create a unique name
        $imageFile = $image->getImage();
        $this->fileName = md5(uniqid()).'.'.$imageFile->guessExtension();
//        check if the file exists
        if (file_exists($this->targetDir.'/'.$this->fileName)) {
            return BoolFlag::IMAGE_ALREADY_EXISTS;
        }
//        set the unique name on the image
        $image->setImage($this->fileName);
//        try to move the file to the directory passed in the constructor
        if (!$imageFile->move($this->targetDir.'/', $this->fileName)) {
            return BoolFlag::IMAGE_UPLOAD_FAILURE;
        }
//      crop the image to 500x500px and save
//        Image::load($this->targetDir.'/'.$this->fileName)
//            ->fit(Manipulations::FIT_STRETCH, 500, 500)
//            ->save();

        return $image;
    }
}
