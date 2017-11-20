<?php
namespace Gungnir\Core;

/**
 * Class that represents a single environment variable
 * that both reads and puts data from a given variable name
 * 
 * @package Gungnir\Core
 */
class EnvironmentVariable 
{

    /** @var String **/
    private $name = null;

    /** @var String **/
    private $value = null;

    /**
     * Magic method toString
     * 
     * @return string
     */
    public function __toString()
    {
        $this->load();
        return $this->getValue();
    }

    /**
     * Set name of environment variable
     * 
     * @param String $name
     * 
     * @return void
     */
    public function setName(String $name)
    {
        $this->name = $name;
    }

    /**
     * Get name of environment variable
     * 
     * @return String
     */
    public function getName() : String
    {
        return $this->name;
    }

    /**
     * Set value of environment variable
     * 
     * @param String $value
     * 
     * @return void
     */
    public function setValue(String $value)
    {
        $this->value = $value;
    }

    /**
     * Get value of environment variable
     * 
     * @return String
     */
    public function getValue() : String
    {
        return $this->value;
    } 

    /**
     * Loads data from environment by set name
     * 
     * @return void
     */
    public function load()
    {
        if ($this->getName()) {
            $this->setValue(getenv($this->getName()));
        }
    }

    /**
     * Stores set value to set name in the environment
     * 
     * @return void
     */
    public function store()
    {
        if ($this->getName() && $this->getValue()) {
            putenv($this->getName() . '=' . $this->getValue());
        }
    }
}