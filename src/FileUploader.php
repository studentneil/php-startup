<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 11/01/2017
 * Time: 23:19.
 */

namespace VinylStore;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class FileUploader
{
    private $targetDir;
    private $fileName;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload($file)
    {
        //        no file, return with error message
        if (!$file) {
            return BoolFlag::IMAGE_UPLOAD_FAILURE;
        }
//        get the actual image from the file entity
//        and create a unique name
        $image = $file->getImage();
        $this->fileName = md5(uniqid()).'.'.$image->guessExtension();
//        check if the file exists
        if (file_exists($this->targetDir.'/'.$this->fileName)) {
            return BoolFlag::IMAGE_ALREADY_EXISTS;
        }
//        set the unique name on the image
        $file->setImage($this->fileName);
//        try to move the file to the directory passed in the constructor
        if (!$image->move($this->targetDir.'/', $this->fileName)) {
            return BoolFlag::IMAGE_UPLOAD_FAILURE;
        }
//      crop the image to 500x500px and save
        Image::load($this->targetDir.'/'.$this->fileName)
            ->fit(Manipulations::FIT_STRETCH, 500, 500)
            ->save();

        return BoolFlag::IMAGE_UPLOAD_SUCCESS;
    }
}
