<?php
namespace Gungnir\Core\Tests;

use Gungnir\Core\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
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

    public function testItReturnsNullWhenNotRegisteredInContainer()
    {
        $container = new Container;
        $this->assertNull($container->get('foo'));
    }

    public function testThatItCanRegisterSingleton()
    {
        $container = new Container;
        $container->singleton('key', function() {
            return new \stdClass();
        });

        $instance = $container->make('key');
        $instance->foo = "bar";

        $this->assertEquals($instance, $container->make('key'));
    }

}
