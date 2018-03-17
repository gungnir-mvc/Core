<?php
namespace Gungnir\Core\Tests;

use Gungnir\Core\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{

    public function testItCanSetCustomApplicationFolder()
    {
        $kernel = new Application('');
        $this->assertEquals('application/', $kernel->getApplicationFolder());

        $kernel->setApplicationFolder('custom_applicationfolder/');

        $this->assertEquals('custom_applicationfolder/', $kernel->getApplicationFolder());
    }

    /**
     * @test
     */
    public function testThatItCanRunMakeAndPassesItself()
    {
        $app = new Application('');
        $app->getContainer()->register('testClosure', function($injectedApp) use ($app) {
            $this->assertEquals($app, $injectedApp);
        });
        $app->make('testClosure');
    }
}
