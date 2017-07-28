<?php

namespace ChrisHarrison\JsonRepository\Persistence;

abstract class PersistableDocument extends \ArrayObject
{
    protected $path;

    public function __construct(string $path, ?array $input = null)
    {
        $this->path = $path;

        if ($input === null) {
            $input = static::load($path);
        }

        parent::__construct($input);
    }

    protected static function load(string $path) : array
    {
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $decode = static::decode($content);
            if (is_array($decode)) {
                return $decode;
            }
        }

        return [];
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

    protected function persist()
    {
        file_put_contents($this->path, $this->encode());
    }

    abstract public function encode() : string;
    abstract public static function decode(string $content) : array;
}