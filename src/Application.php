<?php
namespace Gungnir\Core;

use Gungnir\Event\EventDispatcher;

/**
 * @package gungnir-mvc\core
 * @author Conny Karlsson <connykarlsson9@gmail.com>
 */
class Application implements ApplicationInterface
{

    /** @var EventDispatcher */
    private $eventDispatcher = null;

    /** @var ContainerInterface */
    private $container = null;

    /** @var string */
    private $root = null;

    /** @var string */
    private $applicationFolder = 'application/';

    /**
     * Constructor
     *
     * @param string $root        Absolute path to root folder of project
     * @param int    $environment Which environment is this running
     */
    public function __construct(string $root)
    {
        $this->root = (string) $root;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        if (empty($this->container)) {
            $this->container = new Container();
        }
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return ApplicationInterface
     */
    public function setContainer(ContainerInterface $container): ApplicationInterface
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher(): EventDispatcher
    {
        if (empty($this->eventDispatcher)) {
            $this->eventDispatcher = new EventDispatcher();
        }
        return $this->eventDispatcher;
    }

    /**
     * @param EventDispatcher $eventDispatcher
     *
     * @return ApplicationInterface
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher): ApplicationInterface
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }

    /**
     * Get the registered absolute root path
     *
     * @return string
     */
    public function getRoot() : string
    {
        return $this->root;
    }

    /**
     * {@inheritdoc}
     */
    public function getRootPath(): string
    {
        return $this->getRoot();
    }

    /**
     * Get application folder
     *
     * @deprecated
     * 
     * @return string The application folder
     */
    public function getApplicationFolder() : string
    {
        return $this->applicationFolder;
    }

    /**
     * Set application folder
     *
     * @param string $applicationFolder
     * 
     * @deprecated
     *
     * @return ApplicationInterface
     */
    public function setApplicationFolder(string $applicationFolder): ApplicationInterface
    {
        $this->applicationFolder = $applicationFolder;
        return $this;
    }

    /**
     * Get the absolute path to the application folder
     *
     * @deprecated
     * 
     * @return string
     */
    public function getApplicationPath() : string
    {
        return $this->root . $this->getApplicationFolder();
    }

    /**
     * Runs closure registered in container and passing itself as a first parameter
     *
     * @param string $name
     * @param array $parameters
     *
     * @return mixed
     */
    public function make(string $name, array $parameters = [])
    {
        array_unshift($parameters, $this);
        return $this->getContainer()->make($name, $parameters);
    }
    

}
