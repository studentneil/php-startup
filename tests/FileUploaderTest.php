<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 02/04/2017
 * Time: 22:05
 */

namespace VinylStoreTests;

use VinylStore\FileUploader;
use org\bovigo\vfs\vfsStream;
use VinylStore\Entity\FileEntity;
use VinylStore\BoolFlag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileUploaderTest
 * @package VinylStoreTests
 *
 */
class FileUploaderTest extends \PHPUnit_Framework_TestCase
{
    protected $root;
    protected $uploadDir;
    public function setup()
    {
        $this->root = vfsStream::setup('photos');
        $this->uploadDir = vfsStream::setup('photos/uploadDir');
    }


    /**
     * @covers \VinylStore\FileUploader::upload()
     */
    public function testFileUploader()
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

        $file = new FileEntity();
        $file->setImage($uploadedFile);
        $file->setName('neils_picture');
        $file->setReleaseId('7');

        $uploader = new FileUploader(vfsStream::url('photos/uploadDir'));
        $message = $uploader->upload($file);

        $this->assertSame($message, BoolFlag::IMAGE_UPLOAD_SUCCESS);

    }
}
