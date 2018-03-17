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
    private $container = [];

    /** @var array */
    private $resolvers = [];

    /** @var array */
    private $instances = [];

    /** @var string[] */
    private $singletonKeys = [];

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
    public function store(String $name, $item) : ContainerInterface
    {
        $this->container[$name] = $item;
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

    /**
     * {@inheritdoc}
     */
    public function singleton(string $key, \Closure $singletonFunction): ContainerInterface
    {
        $this->singletonKeys[] = $key;
        return $this->register($key, $singletonFunction);
    }

    /**
     * {@inheritdoc}
     */
    public function register(String $name, Closure $closure) : ContainerInterface
    {
        $this->resolvers[$name] = $closure;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function make(String $name, array $parameters = array())
    {
        
        if ($this->isSingleton($name) && $this->isInstanceRegistered($name)) {
            return $this->instances[$name];
        }   

        $resolver  = $this->getResolver($name);

        if (!$resolver) {
            return null;
        }

        $result = call_user_func_array($resolver, $parameters);
        
        if ($this->isSingleton($name)) {
            $this->instances[$name] = $result;
        }

        return $result;
    }

    /**
     * @param string $name
     * 
     * @return \Closure|null
     */
    private function getResolver(string $name): ?\Closure
    {
        return $this->resolvers[$name] ?? null;
    }

    /**
     * @param string $name
     */
    private function isSingleton(string $name): bool
    {
        return \in_array($name, $this->singletonKeys);
    }

    /**
     * @param string $name
     */
    private function isInstanceRegistered(string $name): bool
    {
        return !empty($this->instances[$name]);
    }
}
