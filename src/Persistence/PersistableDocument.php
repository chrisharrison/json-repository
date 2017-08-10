<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use League\Flysystem\FilesystemInterface;

abstract class PersistableDocument extends \ArrayObject
{
    protected $filesystem;
    protected $path;

    public function __construct(FilesystemInterface $filesystem, string $path, ?array $input = null)
    {
        $this->filesystem = $filesystem;
        $this->path = $path;

        if ($input === null) {
            $input = $this->load();
        }

        parent::__construct($input);
    }

    protected function load() : array
    {
        if ($this->filesystem->has($this->path)) {
            $content = $this->filesystem->read($this->path);
            $decode = $this->decode($content);
            if (is_array($decode)) {
                return $decode;
            }
        }
        
        return [];
    }
    
    protected function persist()
    {
        $this->filesystem->put($this->path, $this->encode());
    }

    public function offsetSet($index, $newval)
    {
        parent::offsetSet($index, $newval);
        $this->persist();
    }

    public function offsetUnset ($index)
    {
        parent::offsetUnset($index);
        $this->persist();
    }

    abstract public function encode() : string;
    abstract public function decode(string $content) : array;
}
