<?php
namespace Gungnir\Core;


interface DirectoryInterface extends FSResource
{

    /**
     * Scans and returns all the content in the folder, result can contain
     * both folders and files
     *
     * @return FileInterface[]|DirectoryInterface[]
     */
    public function scan(): array;

    /**
     * Scans and returns only the files in the folder
     *
     * @return FileInterface[]
     */
    public function scanFiles(): array;

    /**
     * Scans and returns only the folders in the folder
     *
     * @return DirectoryInterface[]
     */
    public function scanDirectories(): array;

    /**
     * Removes all resources in directory and returns the number of resources removed
     * removed
     *
     * @return int
     */
    public function clear(): int;
}