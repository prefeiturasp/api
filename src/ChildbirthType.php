<?php

namespace SuperMae;

class ChildbirthType
{
    const VAGINAL = 1;
    const CESSION = 2;
    const IGNORED = 9;

    private $labels = [
        ChildbirthType::VAGINAL => 'vaginal',
        ChildbirthType::CESSION => 'cession',
        ChildbirthType::IGNORED => 'ignored',
    ];

    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return (string) $this->labels[$this->type];
    }
}
