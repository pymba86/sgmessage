<?php

namespace SgMessage\Strategy\Geometry;

class RawExpConnectionGeometry
{

    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
