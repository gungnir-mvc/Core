<?php
namespace Gungnir\Core\Tests;

use org\bovigo\vfs\vfsStream;
use Gungnir\Core\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanStoreRetrieveAndDeleteData()
    {
        $container = new Container;

        $container->store('foo', 'bar');
        $this->assertEquals('bar', $container->get('foo'));

        $container->remove('foo');
        $this->assertFalse($container->has('foo'));
    }

    public function testItCanRegisterAndMakeClosures()
    {
        $container = new Container;

        $closure = (function($fizz){
            $obj = new \StdClass();
            $obj->foo = 'bar';
            $obj->fizz = $fizz;
            return $obj;
        });

        $container->register('testClosure', $closure);

        $result = $container->make('testClosure', ['buzz']);

        $this->assertEquals($closure('buzz'), $result);
    }
}
