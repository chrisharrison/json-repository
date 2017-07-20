<?php

namespace ChrisHarrison\JsonRepository\Persistence;

class PersistableJsonDocument implements \ArrayAccess
{
    protected $path;
    protected $data;

    public function __construct(string $path, ?array $data = null)
    {
        $this->path = $path;

        if ($data === null) {
            $this->load();
        } else {
            $this->data = $data;
        }
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
        $this->persist();
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
        $this->persist();
    }

    private function load()
    {
        if (file_exists($this->path)) {
            $decode = json_decode(file_get_contents($this->path), true);
            if (is_array($decode)) {
                $this->data = $decode;
                return;
            }
        }
        $this->data = [];
    }

    private function persist()
    {
        file_put_contents($this->path, json_encode($this->data));
    }
}