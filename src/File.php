<?php
namespace Gungnir\Core;

/**
 * Class File
 *
 * @package Gungnir\Core
 */
class File implements FileInterface
{
    /** @var string */
    private $path = null;

    /** @var resource */
    private $fileHandle = null;

    /** @var array */
    private $stat = [];

    /**
     * File constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function open(string $mode = 'c+'): bool
    {
        if ($this->fileHandle) {
            return false;
        }
        $this->fileHandle = fopen($this->getPath(), $mode);
        $this->stat = fstat($this->fileHandle);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close(): bool
    {
        if (empty($this->fileHandle)) {
            return false;
        }

        fclose($this->fileHandle);
        $this->fileHandle = null;
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read(): string
    {
        if (empty($this->fileHandle)) {
            return false;
        }
        $size = $this->stat['size'] ?? null;
        if (empty($size)) {
            return false;
        }

        return fread($this->fileHandle, $size);
    }

    /**
     * {@inheritdoc}
     */
    public function write(string $content): bool
    {
        if (empty($this->fileHandle)) {
            return false;
        }

        fwrite($this->fileHandle, $content);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(): bool
    {
        if ($this->fileHandle) {
            $this->close();
        }

        try {
            unlink($this->getPath());
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): bool
    {
        if ($this->fileHandle) {
            return ftruncate($this->fileHandle, 0);
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function move(string $newPath): bool
    {
        if ($this->fileHandle) {
            $this->close();
        }

        $previousPath = $this->getPath();
        rename($previousPath, $newPath);

        if (file_exists($newPath)) {
            $this->path = $newPath;
            $this->open();
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isDirectory(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isFile(): bool
    {
        return true;
    }
}