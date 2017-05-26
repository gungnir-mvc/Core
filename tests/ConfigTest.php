<?php
namespace Gungnir\Core\Tests;

use org\bovigo\vfs\vfsStream;
use Gungnir\Core\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

  public function testItCanGetAndSetData()
  {
      $expectedData = [
          'one' => 1,
          'two' => 2
      ];

      $config = new Config($expectedData);

      $expectedData['three'] = 3;

      $config->set('three', $expectedData['three']);

      $this->assertEquals($expectedData, $config->data());
  }

  public function testDataCanBeAccessedThroughMagicMethods()
  {
    $config = new Config;

    $config->foo = 'bar';

    $this->assertEquals($config->foo, 'bar');
  }

  public function testDataCanBeLoadedFromArray()
  {
      $config = new Config;

      $config->load(['foo' => 'bar']);

      $this->assertEquals($config->foo, 'bar');
  }

  public function testItCanLoadConfigurationsFromFiles()
  {
      $root = vfsStream::setup('config');
      file_put_contents(vfsStream::url('config/foobar.php'), '<?php return array("foo" => "bar"); ?>');
      file_put_contents(vfsStream::url('config/foobar.ini'), '[foobar]' . PHP_EOL . 'foo = bar');

      $config = new Config(vfsStream::url('config/foobar.php'));
      $this->assertEquals('bar', $config->foo);

      $config = new Config(vfsStream::url('config/foobar.ini'));
      $this->assertEquals('bar', $config->foobar->foo);
  }

  public function testItCanLoadConfigurationFileThroughCascading()
  {
      $root = vfsStream::setup('config');
      file_put_contents(vfsStream::url('config/foobar.php'), '<?php return array("foo" => "bar"); ?>');

      $config = new Config;
      $config->loadFromFileCascading([
        vfsStream::url('config/application/foobar.php'),
        vfsStream::url('config/foobar.php')
      ]);

      $this->assertEquals(vfsStream::url('config/foobar.php'), $config->getFile());
  }

}
