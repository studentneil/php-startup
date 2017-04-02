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
use VinylStore\Entity\FileEntity;
use VinylStore\BoolFlag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderTest extends \PHPUnit_Framework_TestCase
{
    protected $root;
    public function setup()
    {
        $this->root = vfsStream::setup('testUploadDir');
    }
    public function testUploadDirIsCreated()
    {
        $file = vfsStream::url('testUploadDir/test.txt');
        file_put_contents($file, "The new contents of the file");
        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('test.txt'));
    }
    public function testFileUploader()
    {
        $file = new FileEntity();
        $file->setImage('neil.jpg');
        $file->setName('neils_picture');
        $file->setReleaseId('7');
        var_dump($file);
        $mock = $this->getMockBuilder('VinylStore\FileUploader')
            ->setConstructorArgs(array($this->root))
            ->setMethods(array('upload'))
            ->getMock();
        var_dump($mock);
        $mock->expects($this->once())
            ->method('upload')
            ->with($file)
            ->will($this->returnValue(BoolFlag::IMAGE_UPLOAD_SUCCESS));
        $expectedResult = BoolFlag::IMAGE_UPLOAD_SUCCESS;
        $result = $mock->upload($file);
        $this->assertEquals($result, $expectedResult);
    }
}
