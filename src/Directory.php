<?php
namespace Gungnir\Core;


class Directory implements DirectoryInterface
{
    /** @var string */
    private $path = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return (string) $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(): array
    {
        $files = [];
        $rawFiles = scandir($this->path);

        if ($rawFiles) {
            foreach ($rawFiles AS $rawFile) {
                if (is_dir($this->getPath() . "/" . $rawFile)) {
                    $files[] = new Directory($this->path . "/" . $rawFile);
                    continue;
                }
                $files[] = new File($this->path . "/" . $rawFile);
            }
        }

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function scanFiles(): array
    {
        return array_filter($this->scan(), function(FSResource $resource){
            return $resource->isFile();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function scanDirectories(): array
    {
        return array_filter($this->scan(), function(FSResource $resource){
            return $resource->isDirectory();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function move(string $destination): bool
    {
        $success = @rename($this->getPath(), $destination);
        if ($success) {
            $this->path = $destination;
        }
        return $success;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(): bool
    {
        $this->clear();
        return rmdir($this->getPath());
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): int
    {
        $cleared = 0;
        foreach ($this->scan() AS $resource) {
            if (false == in_array($resource->getPath(), [$this->getPath() . '/.', $this->getPath() . '/..'])) {
                if ($resource->delete()) {
                    $cleared++;
                }
            }
        }
        return $cleared;
    }

    /**
     * {@inheritdoc}
     */
    public function isDirectory(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isFile(): bool
    {
        return false;
    }
}