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
}
