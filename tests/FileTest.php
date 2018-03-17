<?php
namespace Gungnir\Core\Tests;

use Gungnir\Core\File;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{

    /**
     * @test
     */
    public function TestThatItKnowsItsType()
    {
        $file = new File("does_not_matter");
        $this->assertFalse($file->isDirectory());
        $this->assertTrue($file->isFile());
    }

    /**
     *
     */
    public function testItCanOpenAnExistingFile()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);
        $file = new File($filePath);
        $file->open();
        $this->assertSame($content, $file->read());
    }

    /**
     *
     */
    public function testItCanWriteToFile()
    {
        $content = 'bar';
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $file = new File($filePath);
        $file->open();
        $file->write($content);
        $file->close();
        $this->assertEquals($content, file_get_contents($filePath));
    }

    /**
     *
     */
    public function testItCanDeleteFile()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);
        $file = new File($filePath);
        $file->open();
        $this->assertTrue($file->delete());
        $this->assertFalse(file_exists($filePath));
    }

    /**
     *
     */
    public function testItCanClearFile()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);
        $file = new File($filePath);
        $file->open();
        $this->assertTrue($file->clear());
        $this->assertTrue(empty(file_get_contents($filePath)));
        $this->assertTrue(file_exists($filePath));
    }

    /**
     *
     */
    public function testItCanMoveAnExistingFile()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $newPath = $rootPath . '/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);
        $file = new File($filePath);
        $file->open();
        $file->move($newPath);
        $this->assertFalse(file_exists($filePath));
        $this->assertTrue(file_exists($newPath));
    }

}