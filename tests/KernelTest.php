<?php
namespace Gungnir\Core\Tests;

use org\bovigo\vfs\vfsStream;
use Gungnir\Core\Kernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanGetVersion()
    {
        $kernel = new Kernel;
        $this->assertNotEmpty($kernel->version());
    }

    public function testItCanOpenApplicationFiles()
    {
        $root = vfsStream::setup();
        $kernel = new Kernel($root->url() . '/');
        $root->addChild(vfsStream::newDirectory('application'));
        file_put_contents($kernel->getApplicationPath() . 'foo.tmp', 'bar');

        $content = $kernel->loadFile($kernel->getApplicationPath() . 'foo.tmp');
        $this->assertSame('bar', $content);
    }

    public function testItCanSetCustomApplicationFolder()
    {
        $kernel = new Kernel;
        $this->assertEquals('application/', $kernel->getApplicationFolder());

        $kernel->setApplicationFolder('custom_applicationfolder/');

        $this->assertEquals('custom_applicationfolder/', $kernel->getApplicationFolder());
    }

    public function testItUsesROOTConstantIfNoRootHaveBeenSet()
    {
        define('ROOT', 'somePath');
        $kernel = new Kernel;
        $this->assertEquals('somePath', $kernel->getRoot());
    }

    public function testItGetsDefaultEnvironmentSet()
    {
        $kernel = new Kernel;
        $this->assertEquals(Kernel::ENVIRONMENT_DEVELOPMENT, $kernel->getEnvironment());
    }
}
