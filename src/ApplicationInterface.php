<?php
namespace Gungnir\Core;


use Gungnir\Event\EventDispatcher;

interface ApplicationInterface
{

    /**
     * Get application event dispatcher
     *
     * @return EventDispatcher
     */
    public function getEventDispatcher(): EventDispatcher;

    /**
     * Set application event dispatcher
     *
     * @param EventDispatcher $eventDispatcher
     *
     * @return ApplicationInterface
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher): ApplicationInterface;

    /**
     * Get application IoC container
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface;

    /**
     * Set application IoC container
     *
     * @param ContainerInterface $container
     *
     * @return ApplicationInterface
     */
    public function setContainer(ContainerInterface $container): ApplicationInterface;

    /**
     * Set the name of application folder for project
     *
     * @param string $folder
     *
     * @return ApplicationInterface
     */
    public function setApplicationFolder(String $folder): ApplicationInterface;

    /**
     * Get absolute path to application folder from
     * project root
     *
     * @return string
     */
    public function getApplicationPath(): String;

    /**
     * Get absolute path to project root
     *
     * @return String
     */
    public function getRootPath(): String;

    /**
     * Runs closure registered in container and passing itself as a first parameter
     *
     * @param string $name
     * @param array $parameters
     *
     * @return mixed
     */
    public function make(string $name, array $parameters = []);
}