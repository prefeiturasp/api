<?php

namespace SuperMae\Establishments;

use SuperMae\Coordinates;

class Statistic
{
    public $name;
    public $totalMothers;
    /**
     * @var Coordinates
     */
    public $coordinates;

    public function __construct($name, Coordinates $coordinates, $totalMothers)
    {
        $this->name = $name;
        $this->totalMothers = $totalMothers;
        $this->coordinates = $coordinates;
    }
}
