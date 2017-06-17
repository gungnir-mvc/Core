<?php
namespace Gungnir\Core;

use Gungnir\Event\EventDispatcher;
use Gungnir\Event\GenericEventObject;

/**
 * @package gungnir-mvc\core
 * @author Conny Karlsson <connykarlsson9@gmail.com>
 */
class Application implements ApplicationInterface
{
    const KERNEL_VERSION = '1.0.0';

    const CONST_NAME_ROOT_PATH = 'ROOT';

    const ENVIRONMENT_DEVELOPMENT = 0;
    const ENVIRONMENT_STAGE       = 1;
    const ENVIRONMENT_PRODUCTION  = 2;

    /** @var EventDispatcher */
    private $eventDispatcher = null;

    /** @var ContainerInterface */
    private $container = null;

    /** @var Int */
    private $environment = null;

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
    public function __construct(String $root = null, Int $environment = self::ENVIRONMENT_DEVELOPMENT)
    {
        $this->environment = $environment;

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
            $this->loadApplicationEventListeners();
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
     * Get version of current Kernel
     *
     * @return String
     */
    public function version() : String
    {
        return self::KERNEL_VERSION;
    }

    /**
     * Get which environment mode the kernel is running
     * in
     *
     * @return Int
     */
    public function getEnvironment()
    {
        return $this->environment;
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
     * Loads a given file
     *
     * @param String $path The absolute path to desired file
     *
     * @return Mixed Content of file or null if file does not exist
     */
    public function loadFile(String $path)
    {
        $content = null;
            if (file_exists($path)) {
                ob_start();
                require $path;
                $content = ob_get_clean();
            }
        return $content;
    }

    /**
     * Loads event listeners for application
     *
     * @return void
     */
    private function loadApplicationEventListeners()
    {
        $appRoot        = $this->getApplicationPath();
        $file           = $appRoot . 'config/EventListeners.php';
        $eventListeners = file_exists($file) ? require $file : [];

        if (empty($eventListeners) !== true && is_array($eventListeners)) {
            $this->getEventDispatcher()->registerListeners($eventListeners);
        }

        $eventName = 'gungnir.framework.loadapplicationeventlisteners.done';
        $this->getEventDispatcher()->emit($eventName, new GenericEventObject($this));
    }

}
