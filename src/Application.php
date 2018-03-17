<?php
namespace Gungnir\Core;

use Gungnir\Event\EventDispatcher;

/**
 * @package gungnir-mvc\core
 * @author Conny Karlsson <connykarlsson9@gmail.com>
 */
class Application implements ApplicationInterface
{

    const CONST_NAME_ROOT_PATH = 'ROOT';

    /** @var EventDispatcher */
    private $eventDispatcher = null;

    /** @var ContainerInterface */
    private $container = null;

    /** @var String */
    private $root = null;

    /** @var String */
    private $applicationFolder = 'application/';

    /**
     * Constructor
     *
     * @param String $root        Absolute path to root folder of project
     * @param Int    $environment Which environment is this running
     */
    public function __construct(String $root = null)
    {
        $this->root = (string) $root;

        if (empty($this->root) && defined(self::CONST_NAME_ROOT_PATH)) {
            $this->root = ROOT;
        }
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
     * @return String
     */
    public function getRoot() : String
    {
        return $this->root;
    }

    /**
     * {@inheritdoc}
     */
    public function getRootPath(): String
    {
        return $this->getRoot();
    }

    /**
     * Get application folder
     *
     * @return String The application folder
     */
    public function getApplicationFolder() : String
    {
        return $this->applicationFolder;
    }

    /**
     * Set application folder
     *
     * @param String $applicationFolder
     *
     * @return ApplicationInterface
     */
    public function setApplicationFolder(String $applicationFolder): ApplicationInterface
    {
        $this->applicationFolder = $applicationFolder;
        return $this;
    }

    /**
     * Get the absolute path to the application folder
     *
     * @return String
     */
    public function getApplicationPath() : String
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
