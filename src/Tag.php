<?php

namespace MPhpMaster\ZATCA;

class Tag
{
    protected int $tag;
    protected string $value;

    public function __construct(int $tag, string $value)
    {
        $this->tag = $tag;
        $this->value = $value;
    }

    public static function make(): self
    {
        return new static(...func_get_args());
    }

    public function __toString()
    {
        return
            $this->toHex($this->tag) .
            $this->toHex(strlen($this->value)) .
            $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return false|string
     */
    protected function toHex($value)
    {
        return pack("H*", sprintf("%02X", $value));
    }
}
