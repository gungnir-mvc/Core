<?php
namespace Gungnir\Core;

/**
 * @package gungnir-mvc\core
 * @author Conny Karlsson <connykarlsson9@gmail.com>
 */
class Kernel
{
    const VERSION = '0.1.0';

    const CONST_NAME_ROOT_PATH = 'ROOT';

    const ENVIRONMENT_DEVELOPMENT = 0;
    const ENVIRONMENT_STAGE       = 1;
    const ENVIRONMENT_PRODUCTION  = 2;

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
     * Get version of current Kernel
     *
     * @return String
     */
    public function version() : String
    {
        return self::VERSION;
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
     * @return Self
     */
    public function setApplicationFolder(String $applicationFolder)
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

}
