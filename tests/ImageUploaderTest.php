<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 02/04/2017
 * Time: 22:05
 */

namespace VinylStoreTests;

use VinylStore\ImageUploader;
use org\bovigo\vfs\vfsStream;
use VinylStore\Entity\ImageEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use PHPUnit\Framework\TestCase;
use VinylStore\MessageService;

/**
 * Class ImageUploaderTest
 * @package VinylStoreTests
 *
 */
class ImageUploaderTest extends TestCase
{
    protected $root;
    protected $uploadDir;
    public function setup()
    {
        $this->root = vfsStream::setup('photos');
        $this->uploadDir = vfsStream::setup('photos/uploadDir');
    }


    /**
     * @covers \VinylStore\ImageUploader::upload()
     */
    public function testFileUploaderWithImage()
    {
        vfsStream::newFile('testFile.jpg', 0777)->at($this->root);

        imagejpeg(imagecreatetruecolor(120, 20), $this->root->url().'/testFile.jpg');

        $uploadedFile = new UploadedFile(
            $this->root->url().'/testFile.jpg',
            'testFile.jpg',
            null,
            3000,
            UPLOAD_ERR_OK,
            true
        );

        $file = new ImageEntity();
        $file->setImage($uploadedFile);
        $file->setReleaseId('7');

        $uploader = new ImageUploader(vfsStream::url('photos/uploadDir'));
        $uploadedImage = $uploader->upload($file);
//        var_dump($this->uploadDir->getChildren());
        $this->assertInstanceOf(ImageEntity::class, $uploadedImage);

    }

    /**
     * @covers \VinylStore\ImageUploader::__construct()
     */
    public function testImageUploaderConstructor()
    {
        $uploader = new ImageUploader(vfsStream::url('photos/uploadDir'));
        $this->assertEquals($uploader->getTargetDir(), vfsStream::url('photos/uploadDir'));
    }

}
