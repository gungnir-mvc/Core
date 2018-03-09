<?php
namespace Gungnir\Core;

class Environment implements EnvironmentInterface {
    
    /** @var string[] */
    private $variables = null;

    /**
     * @param string[] $variables Assoc array of key:value paired variables
     */
    public function __construct(array $variables = []) 
    {
        $this->variables = $variables;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnvironmentVariable(string $name): ?EnvironmentVariable
    {
        if (false === empty($this->variables[$name])) {
            $variable = new EnvironmentVariable();
            $variable->setName($name);
            $variable->setValue($this->variables[$name]);
            return $variable;
        }        
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function storeEnvironmentVariable(EnvironmentVariable $variable): EnvironmentInterface
    {
        $this->variables[$variable->getName()] = $variable->getValue();
        return $this;
    }
}