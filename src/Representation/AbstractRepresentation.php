<?php

namespace App\Representation;

abstract class AbstractRepresentation
{
    public $code;
    public $meta;

    public function addCode($value)
    {
        if (isset($this->code)) {
            throw new \LogicException(sprintf('This code already exists. You are trying to override this code, use the setCode method instead for the %s code.', $value));
        }

        $this->setCode($value);
    }

    public function setCode($value)
    {
        $this->code = $value;
    }

    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. You are trying to override this meta, use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}
