<?php

namespace SuperMae;

class Address
{
    public $zipCode;
    public $street;
    public $number;
    public $neighborhood;
    /**
     * @var Coordinates
     */
    public $coordinates;

    public function __construct($zipCode, $street, $number, $neighborhood, Coordinates $coordinates)
    {
        $this->zipCode = $zipCode;
        $this->street = $street;
        $this->number = $number;
        $this->neighborhood = $neighborhood;
        $this->coordinates = $coordinates;
    }
}
