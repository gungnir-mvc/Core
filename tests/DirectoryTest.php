<?php
namespace Gungnir\Core\Tests;

use Gungnir\Core\Directory;
use Gungnir\Core\DirectoryInterface;
use Gungnir\Core\FileInterface;
use Gungnir\Core\FSResource;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class DirectoryTest extends TestCase
{
    /**
     * @test
     */
    public function TestThatItKnowsItsType()
    {
        $directory = new Directory("does_not_matter");
        $this->assertTrue($directory->isDirectory());
        $this->assertFalse($directory->isFile());
    }

    /**
     * @test
     */
    public function TestThatItCanReturnThePath()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();

        $directory = new Directory($rootPath . '/files');

        $this->assertEquals($rootPath . '/files', $directory->getPath());
    }

    /**
     * @test
     */
    public function TestThatItCanScanForResources()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);

        $directory = new Directory($rootPath . '/files');
        $files = $directory->scan();

        /**
         * Should contain
         * ./.       which is a folder
         * ./..      which is a folder
         * ./foo.tmp which is a file
         */
        $this->assertEquals(3, count($files));
        foreach ($files AS $file) {
            $this->assertInstanceOf(FSResource::class, $file);
        }
    }

    /**
     * @test
     */
    public function TestThatItCanScanForFiles()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);

        $directory = new Directory($rootPath . '/files');
        $files = $directory->scanFiles();

        $this->assertEquals(1, count($files));
        foreach ($files AS $file) {
            $this->assertInstanceOf(FileInterface::class, $file);
        }
    }

    /**
     * @test
     */
    public function TestThatItCanScanForDirectories()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);

        $directory = new Directory($rootPath . '/files');
        $files = $directory->scanDirectories();

        $this->assertEquals(2, count($files));
        foreach ($files AS $file) {
            $this->assertInstanceOf(DirectoryInterface::class, $file);
        }
    }

    /**
     * @test
     */
    public function testThatDirectoryCanBeMoved()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();

        $directory = new Directory($rootPath . '/files');


        $this->assertTrue($directory->move($rootPath . '/moved_files'));
        $this->assertTrue(is_dir($rootPath . '/moved_files'), "Directory where not moved when supposed too");
    }

    /**
     * @test
     */
    public function testThatDirectoryCanBeDeleted()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);

        $directory = new Directory($rootPath . '/files');
        $directory->delete();

        $this->assertFalse(is_dir($rootPath . '/files'), "Directory where not deleted when supposed too");
    }

    /**
     * @test
     */
    public function testThatDirectoryCanBeCleared()
    {
        $root = vfsStream::setup();
        $root->addChild(vfsStream::newDirectory('files'));
        $rootPath = $root->url();
        $filePath = $rootPath . '/files/foo.tmp';
        $content = 'bar';
        file_put_contents($filePath, $content);

        $directory = new Directory($rootPath . '/files');
        $removedResources = $directory->clear();

        $this->assertEquals(1, $removedResources);
    }
}