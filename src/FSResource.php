<?php
namespace Gungnir\Core;


interface FSResource
{
    /**
     * Returns the full path to this resource
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Checks if this resource is a directory
     *
     * @return bool
     */
    public function isDirectory(): bool;

    /**
     * Checks if this resource is a file
     *
     * @return bool
     */
    public function isFile(): bool;

    /**
     * Moves the resource to the passed destination and returns
     * true when successful.
     *
     * @param string $destination
     *
     * @return bool
     */
    public function move(string $destination): bool;

    /**
     * Deletes the resource and returns true when successful
     *
     * @return bool
     */
    public function delete(): bool;
}