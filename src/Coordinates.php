<?php

namespace SuperMae;

class Coordinates
{
    public $latitude = 0.0;
    public $longitude = 0.0;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = floatval($latitude);
        $this->longitude = floatval($longitude);
    }

}
