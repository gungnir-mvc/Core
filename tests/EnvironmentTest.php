<?php
namespace Gungnir\Core\Tests;

use Gungnir\Core\EnvironmentVariable;
use PHPUnit\Framework\TestCase;
use \Gungnir\Core\Environment;

class EnvironmentTest extends TestCase {
    /**
     * @test
     */
    public function testThatEnvironmentVariableCanBeStored()
    {
        $environment = new Environment();
        $expectedVariable = new EnvironmentVariable();
        $expectedVariable->setName("foo");
        $expectedVariable->setValue("bar");

        $environment->storeEnvironmentVariable($expectedVariable);

        $actualVariable = $environment->getEnvironmentVariable("foo");

        $this->assertEquals(
            $expectedVariable->getName(), 
            $actualVariable->getName()
        );
        $this->assertEquals(
            $expectedVariable->getValue(), 
            $actualVariable->getValue()
        );
    }

}