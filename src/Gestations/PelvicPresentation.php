<?php

namespace SuperMae\Gestations;

class PelvicPresentation implements \JsonSerializable
{
    const CEPHALIC = 1;
    const PELVIC = 2;
    const TRANSVERSE = 3;
    const IGNORED = 9;

    private $labels = [
        PelvicPresentation::CEPHALIC => 'cephalic',
        PelvicPresentation::PELVIC => 'pelvic',
        PelvicPresentation::TRANSVERSE => 'transverse',
        PelvicPresentation::IGNORED => 'ignored',
    ];

    private $presentation;

    public function __construct($presentation)
    {
        if (empty($presentation)) {
            $presentation = self::IGNORED;
        }
        if (!isset($this->labels[$presentation])) {
            throw new \DOMException('Pelvic Presentation not found');
        }

        $this->presentation = $presentation;
    }

    public function __toString()
    {
        return (string) $this->labels[$this->presentation];
    }

    public function jsonSerialize()
    {
        return (string) $this;
    }

}
