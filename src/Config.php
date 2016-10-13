<?php
namespace Gungnir\Core;

use \Gungnir\Core\Core as Gungnir;

/**
 * @package gungnir-mvc\core
 * @author Conny Karlsson <connykarlsson9@gmail.com>
 */
class Config
{
    /** @var String $file The file path configuration was loaded from */
    private $file = null;

    /** @var String[] Array of paths to where file could be found **/
    private $paths = [];

    /** @var array $data Container array for config content */
    private $data = [];

    /**
     * Constructor
     *
     * @param Array|String $data Either string which is a path or array of data that is the config
     */
    public function __construct($data = null)
    {
        if (is_array($data)) {
            $this->load($data);
        } elseif (is_string($data)) {
            $this->loadFromFile($data);
        }
    }

    public function __get(String $key)
    {
        return $this->get($key);
    }

    public function __set(String $key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Checks and retrieves configuration option
     * if it exists.
     *
     * @param  String $key Name of configuration option
     * @return mixed Content of configuration option or boolean false if it doesnt exist
     */
    public function get(String $key)
    {
        return $this->data[$key] ?? false;
    }

    /**
     * Stores a configuration option under given key
     *
     * @param String $key   Name that the value should be stored under
     * @param Mixed  $value Content that should be stored
     * @return Config
     */
    public function set(String $key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Getter/Setter method for all config
     *
     * @return Array configuration container
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Get filepath currently loaded
     *
     * @return String
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Loads an array into configuration storage.
     * Any sub-arrays will be converted to new configuration
     * objects.
     *
     * @param  Array  $data Data to be loaded into configuration object
     * @return void
     */
    public function load(Array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $config = new Config($value);
                $config->set('parent', $key);
                $this->data[$key] = $config;
            } else {
                $this->data[$key] = $value;
            }
        }
    }

    /**
     * Add a path to the stack of which this configuration
     * is tried to be loaded from
     *
     * @param String $path The given path
     *
     * @return Self
     */
    public function addPath(String $path)
    {
        $this->paths[] = $path;
        return $this;
    }

    /**
     * Loads an array from external file and then call
     * internal load() method.
     *
     * @param  String $path Full path to file with configuration array in it.
     * @return Config
     */
    public function loadFromFile(String $path)
    {
        if (file_exists($path)) {
            $this->file = $path;
            $data = [];

            if (strpos($this->file, '.php') !== false) {
                $data += $this->loadPhpConfigurationFile($this->file);
            } elseif (strpos($this->file, '.ini') !== false) {
                $data += $this->loadIniConfigurationFile($this->file);
            }

            $this->load($data);
        }
        return $this;
    }

    /**
     * Loads configuration array from a file with the
     * php (.php) file extension
     *
     * @param string $path Full path to the php configuration file
     *
     * @return array
     */
    public function loadPhpConfigurationFile(String $path)
    {
        $configData = (array) require $path;
        return $configData;
    }

     /**
     * Loads configuration array from a file with the
     * ini (.ini) file extension
     *
     * @param string $path Full path to the php configuration file
     *
     * @return array
     */
    public function loadIniConfigurationFile(String $path)
    {
        return parse_ini_file($path, true, INI_SCANNER_TYPED);
    }

    /**
     * Loads content from external file by cascading down through the
     * given array of absolute paths
     *
     * @param  String[] $paths        Array of absolute paths to try and find config file
     *
     * @return Config
     */
    public function loadFromFileCascading(Array $paths = [])
    {
        $paths = empty($paths) ? $this->paths : $paths;
        foreach ($paths as $key => $value) {
            if (empty($this->file)) {
                $this->loadFromFile($value);
            }
        }
        return $this;
    }
}
