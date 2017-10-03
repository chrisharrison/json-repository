<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use ChrisHarrison\JsonRepository\Persistence\Encoders\PersistableDocumentEncoder;
use League\Flysystem\FilesystemInterface;

final class PersistableDocument extends \ArrayObject
{
    private $filesystem;
    private $path;
    private $encoder;

    public function __construct(FilesystemInterface $filesystem, string $path, PersistableDocumentEncoder $encoder, ?array $input = null)
    {
        $this->filesystem = $filesystem;
        $this->path = $path;
        $this->encoder = $encoder;

        if ($input === null) {
            $input = $this->load();
        }

        parent::__construct($input);
    }

    protected function load() : array
    {
        if ($this->filesystem->has($this->path)) {
            $content = $this->filesystem->read($this->path);
            $decode = $this->encoder->decode($content);
            if (is_array($decode)) {
                return $decode;
            }
        }

        return [];
    }
    
    protected function persist()
    {
        $this->filesystem->put($this->path, $this->encoder->encode((array) $this));
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
}
