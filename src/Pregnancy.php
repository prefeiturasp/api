<?php

namespace SuperMae;

class Pregnancy implements \JsonSerializable
{
    const UNIQUE = 1;
    const DOUBLE = 2;
    const TRIPLE = 3;
    const IGNORED = 9;

    private $labels = [
        Pregnancy::UNIQUE => 'unique',
        Pregnancy::DOUBLE => 'double',
        Pregnancy::TRIPLE => 'triple',
        Pregnancy::IGNORED => 'ignored',
    ];

    private $pregnancy;

    public function __construct($type)
    {
        if (!in_array($type, array_keys($this->labels))) {
            throw new \DOMException('Pregnancy not found');
        }

        $this->pregnancy = $type;
    }

    public function __toString()
    {
        return (string) $this->labels[$this->pregnancy];
    }

    public function jsonSerialize()
    {
        return (string) $this->pregnancy;
    }
}
