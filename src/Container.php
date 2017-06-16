<?php
namespace Gungnir\Core;

use Closure;

/**
 * @package gungnir-mvc\core
 * @author Conny Karlsson <connykarlsson9@gmail.com>
 */
class Container
{
    /** Container $instance The current global instance of Container */
    private static $instance = null;

    /** @var array $container Container array for everything stored in container */
    private $container = array();

    /**
     * Get current global instance of Container or set current global instance
     * if an instance of Container is passed
     *
     * @param Container $instance If passed it replaces the global instance
     * 
     * @return Container|Null
     */
    public static function instance(Container $instance = null)
    {
        if ($instance) {
            self::setInstance($instance);
        }
        return self::getInstance();
    }

    /**
     * Set the current global instance of Container
     *
     * @param Container $instance The instance to set as global
     * 
     * @return void
     */
    public static function setInstance(Container $instance)
    {
        self::$instance = $instance;
    }

    /**
     * Get current global instance of Container
     *
     * @return Container|Null
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Tries to get an item from container by name
     *
     * @param  String $name Name of item to retrieve
     * 
     * @return Mixed
     */
    public function get(String $name)
    {
        if ($this->has($name)) {
            return $this->container[$name];
        }

        return null;
    }

    /**
     * Checks if name is registered in container
     *
     * @param  String  $name Name to check for in container
     * 
     * @return boolean
     */
    public function has(String $name)
    {
        return isset($this->container[$name]);
    }

    /**
     * Retrieves and runs closure from container
     *
     * @param  String $name       Name of closure;
     * @param  array  $parameters Array with parameters to pass into closure
     * 
     * @return Mixed
     */
    public function make(String $name, array $parameters = array())
    {
        $item = $this->get($name);

        return call_user_func_array($item, $parameters);
    }

    /**
     * Stores data in container under the passed name
     *
     * @param  String $name Name to store item under
     * @param  Mixed  $item Anyting that should be stored
     * 
     * @return Container
     */
    public function store(String $name, $item) : Container
    {
        $this->container[$name] = $item;
        return $this;
    }

    /**
     * Stores a closure in the container under the passed name
     *
     * @param  String  $name    Name to store closure under
     * @param  Closure $closure Closure to register
     * 
     * @return Container
     */
    public function register(String $name, Closure $closure) : Container
    {
        $this->store($name, $closure);
        return $this;
    }

    /**
     * Removes item from container by name
     *
     * @param  String $name Name of item to remove
     * 
     * @return Container
     */
    public function remove(String $name) : Container
    {
        if ($this->has($name)) {
            unset($this->container[$name]);
        }
        return $this;
    }
}
