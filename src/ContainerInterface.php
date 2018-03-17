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
     * @param  String  $key Name to check for in container
     *
     * @return boolean
     */
    public function has(string $key): bool;

    /**
     * Tries to get an item from container by name
     *
     * @param  String $key Name of item to retrieve
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * Stores data in container under the passed name
     *
     * @param  String $key Name to store item under
     * @param  mixed  $value Anything that should be stored
     *
     * @return ContainerInterface
     */
    public function store(string $key, $value): ContainerInterface;

    /**
     * Removes item from container by name
     *
     * @param  String $key Name of item to remove
     *
     * @return ContainerInterface
     */
    public function remove(string $key): ContainerInterface;

    /**
     * Works like register but the first time the closure is called the
     * returned value is stored and will be returned instead of having the
     * closure run again
     * 
     * @param string   $key
     * @param \Closure $singletonFunction
     */
    public function singleton(string $key, \Closure $singletonFunction): ContainerInterface;

    /**
     * Stores a closure in the container under the passed name.
     *
     * @param  String  $closureName    Name to store closure under
     * @param  Closure $closure Closure to register
     *
     * @return ContainerInterface
     */
    public function register(string $closureName, Closure $closure): ContainerInterface;

    /**
     * Retrieves and runs closure from container
     *
     * @param  String $closureName       Name of closure;
     * @param  array  $parameters Array with parameters to pass into closure
     *
     * @return mixed
     */
    public function make(string $closureName, array $parameters = []);

}