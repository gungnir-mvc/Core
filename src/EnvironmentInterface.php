<?php
namespace Gungnir\Core;

interface EnvironmentInterface {

    /**
     * Retrieve an environment variable 
     * 
     * @param string $name The name of environment variable to retrieve
     * 
     * @return EnvironmentVariable|null
     */
    public function getEnvironmentVariable(string $name): ?EnvironmentVariable;

    /**
     * Store an environment variable
     * 
     * @param EnvironmentVariable $variable The variable to store in the environment
     * 
     * @return EnvironmentInterface
     */
    public function storeEnvironmentVariable(EnvironmentVariable $variable): EnvironmentInterface;

}