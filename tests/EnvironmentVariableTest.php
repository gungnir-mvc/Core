<?php
namespace Gungnir\Core\Tests;

use Gungnir\Core\EnvironmentVariable;
use PHPUnit\Framework\TestCase;

class EnvironmentVariableTest extends TestCase
{
    /**
     * @test
     */
    public function testThatItCanStoreEnvironmentVariable()
    {
        $name  = 'test_env_var_name';
        $value = 'test_env_var_value';
        $env   = new EnvironmentVariable();
        $env->setName($name);
        $env->setValue($value);
        $env->store();

        $result = getenv($name);

        $this->assertEquals($value, $result);
    }

    /**
     * @test
     */
    public function testThatItCanRetrieveValueFromEnvironment()
    {
        $name  = 'test_env_var_name';
        $value = 'test_env_var_value';

        putenv($name . '=' . $value);

        $env   = new EnvironmentVariable();
        $env->setName($name);

        $env->load();

        $this->assertEquals($value, $env->getValue());
    }
}