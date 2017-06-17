<?php
namespace Gungnir\Core;

use Closure;

/**
 * Interface ContainerInterface
 * @package Gungnir\Core
 */
interface ContainerInterface
{

    /**
     * Checks if name is registered in container
     *
     * @param  String  $name Name to check for in container
     *
     * @return boolean
     */
    public function has(string $key): bool;

    /**
     * Tries to get an item from container by name
     *
     * @param  String $name Name of item to retrieve
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * Removes item from container by name
     *
     * @param  String $name Name of item to remove
     *
     * @return ContainerInterface
     */
    public function remove(string $key): ContainerInterface;

    /**
     * Retrieves and runs closure from container
     *
     * @param  String $name       Name of closure;
     * @param  array  $parameters Array with parameters to pass into closure
     *
     * @return mixed
     */
    public function make(string $closureName, array $parameters = []);

    /**
     * Stores data in container under the passed name
     *
     * @param  String $name Name to store item under
     * @param  mixed  $item Anything that should be stored
     *
     * @return ContainerInterface
     */
    public function store(string $key, $value): ContainerInterface;

    /**
     * Stores a closure in the container under the passed name
     *
     * @param  String  $name    Name to store closure under
     * @param  Closure $closure Closure to register
     *
     * @return ContainerInterface
     */
    public function register(string $closureName, Closure $closure): ContainerInterface;
}