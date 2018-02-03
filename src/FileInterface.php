<?php
namespace Gungnir\Core;

/**
 * Interface FileInterface
 * @package Gungnir\Core
 */
interface FileInterface
{
    /**
     * Opens file to enable reading and
     * writing of content
     *
     * @param string $mode In which mode should the file be opened
     *
     * @return bool
     */
    public function open(string $mode = 'c+'): bool;

    /**
     * Closes file
     *
     * @return bool
     */
    public function close(): bool;

    /**
     * Reads content of opened file
     *
     * @return string
     */
    public function read(): string;

    /**
     * Writes data to the file
     *
     * @param string $content
     *
     * @return bool
     */
    public function write(string $content): bool;

    /**
     * Removes the file from the system
     *
     * @return bool
     */
    public function delete(): bool;

    /**
     * Clears content of file, resulting in an
     * empty file.
     *
     * @return bool
     */
    public function clear(): bool;

    /**
     * Moves file to new passed path
     *
     * @param string $newPath
     *
     * @return bool
     */
    public function move(string $newPath): bool;

    /**
     * Returns the full path to file
     *
     * @return string
     */
    public function getPath(): string;

}