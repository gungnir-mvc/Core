<?php
namespace Gungnir\Core;

/**
 * An autoloader created to allow overriding classes by defining
 * them inside the same namespace but inside application scope.
 * Whenever a system or vendor class is called and there exists
 * another class with the same namespace and name in application scope
 * then that one will be loaded and used instead.
 *
 * @package gungnir-mvc\core
 * @author Conny Karlsson <connykarlsson9@gmail.com>
 */
class Autoloader
{
    /** @var String **/
    private $root = null;

    /** @var string Path to application folder relative to root directory */
    private $applicationFolder = 'application/';

    /** @var array $psr4 Container array for PSR-4 prefixes */
    private $psr4 = [];

    /** @var array $psr0 Container array for PSR-0 prefixes */
    private $psr0 = [];

    /** Constructor
     *
     * @param String $root    Absolute path to root directory
     */
    public function __construct(String $root)
    {
        $this->root = $root;
    }

    /**
     * Main framework autoloader
     * This method should be registered with
     * spl_autoload_register
     *
     * @param  string $class String representation of class that should get loaded
     * 
     * @return null|bool
     */
    public function classLoader(String $class) 
    {

        $path = $this->getApplicationPath($class);
        $path = empty($path) ? $this->getPsr4Path($class) : $path;

        if (empty($path)) {
            return false;
        }

        require $path;
    }

    /**
     * Tries to locate passed $class in registered PSR-4 prefixes
     * and returns path to class if found.
     *
     * @param  String $class String representation of class that should be found
     * 
     * @return Bool|String     String $path if found or Bool false if not
     */
    public function getPsr4Path(String $class)
    {
        $path = strtr($class, '\\', '/') . '.php';

        foreach ($this->psr4 as $prefix => $src) {
            if (strpos($class, $prefix) !== false) {
                $prefix    = strtr($prefix, '\\', '/');
                $classPath = str_replace($prefix, '', $path);
                $psr4Path  = $src . ltrim($classPath, '/');
                if (file_exists($psr4Path)) {
                    return $psr4Path;
                }
            }
        }
        return false;
    }

    /**
     * Get the relative path to application folder
     *
     * @return String
     */
    public function getApplicationFolder()
    {
        return $this->applicationFolder;
    }

    /**
     * Set the relative path to application folder
     *
     * @param String $applicationFolder
     *
     * @return Autoloader
     */
    public function setApplicationFolder(String $applicationFolder)
    {
        $this->applicationFolder = $applicationFolder;
        return $this;
    }

    /**
     * Tries to locate passed $class in framework system scope
     * and returns path to class if found.
     *
     * @param  String $class String representation of class that should be found
     * 
     * @return Bool|String     String $path if found or Bool false if not
     */
    public function getApplicationPath(String $class)
    {
        $applicationPath  = $this->root . '/';
        $applicationPath .= $this->getApplicationFolder() . 'classes/';
        $applicationPath .= strtr($class, '\\', '/') . '.php';

        if (file_exists($applicationPath)) {
            return $applicationPath;
        }

        return false;
    }

    /**
     * Register a prefix with a path to the PSR-4 container
     *
     * @param  String $prefix Prefix
     * @param  String $src    Path
     * 
     * @return void
     */
    public function psr4Prefix(String $prefix, String $src)
    {
        $this->psr4[rtrim($prefix, '/')] = rtrim($src, '/').'/';
    }

    /**
     * Register a prefix with a path to the PSR-0 container
     *
     * @param  String $prefix Prefix
     * @param  String $src    Path
     * 
     * @return void
     */
    public function psr0Prefix(String $prefix, String $src)
    {
        $this->psr0[rtrim($prefix, '/')] = rtrim($src, '/').'/';
    }

    /**
     * Returns all registered prefixes
     *
     * @param  String|null $preference Pass psr0 or psr4 for only getting either of the sets
     * 
     * @return array The prefixes
     */
    public function prefixes(String $preference = null)
    {
        switch ($preference) {
            case 'psr4':
                return $this->psr4;
            case 'psr0':
                return $this->psr0;
            default:
                return array_merge($this->psr4, $this->psr0);
        }
    }
}