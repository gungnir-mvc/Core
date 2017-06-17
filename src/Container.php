<?php
namespace Gungnir\Core;

use Closure;

/**
 * Inversion of control container with basic functionality
 *
 * @package gungnir-mvc\core
 * @author Conny Karlsson <connykarlsson9@gmail.com>
 */
class Container implements ContainerInterface
{

    /** @var array $container Container array for everything stored in container */
    private $container = array();

    /**
     * {@inheritdoc}
     */
    public function get(String $name)
    {
        if ($this->has($name)) {
            return $this->container[$name];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function has(String $name): bool
    {
        return isset($this->container[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function make(String $name, array $parameters = array())
    {
        $item = $this->get($name);

        return call_user_func_array($item, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function store(String $name, $item) : ContainerInterface
    {
        $this->container[$name] = $item;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function register(String $name, Closure $closure) : ContainerInterface
    {
        $this->store($name, $closure);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(String $name) : ContainerInterface
    {
        if ($this->has($name)) {
            unset($this->container[$name]);
        }
        return $this;
    }
}
