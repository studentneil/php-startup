<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 02/04/2017
 * Time: 22:05
 */

namespace VinylStoreTests;


use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use VinylStore\FileUploader;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use VinylStore\Entity\FileEntity;
use VinylStore\BoolFlag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderTest extends \PHPUnit_Framework_TestCase
{
    protected $root;
    protected $uploadDir;
    public function setup()
    {
        $this->root = vfsStream::setup('photos');
        $this->uploadDir = vfsStream::setup('photos/uploadDir');
    }
    public function testUploadDirIsCreated()
    {
        $file = vfsStream::url('photos/test.txt');
        file_put_contents($file, "The new contents of the file");
        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('test.txt'));
    }

    public function testFileUploader()
    {

        imagejpeg(imagecreatetruecolor(120, 20), $this->root->url().'/testFile.jpg');

        vfsStream::newFile('testFile.jpg', 0777)->at($this->root);
        $uploadedFile = new UploadedFile(
            $this->root->url().'/testFile.jpg',
            'testFile.jpg',
            'image/jpeg',
            null,
            UPLOAD_ERR_OK,
            true
        );


        $file = new FileEntity();
        $file->setImage($uploadedFile);
        $file->setName('neils_picture');
        $file->setReleaseId('7');
        var_dump($file);
        var_dump($uploadedFile);
        $mock = $this->getMockBuilder('VinylStore\FileUploader')
            ->setConstructorArgs(array(vfsStream::url('photos/uploadDir/')))
            ->setMethods(null)
            ->getMock();
        var_dump($mock);
        $mock->upload($file);
        var_dump($file->getImage());
        $this->assertTrue($this->uploadDir->hasChild($file->getImage()));

    }
}
