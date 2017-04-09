<?php

namespace SuperMae;

class Establishment implements \JsonSerializable
{
    public $id;
    public $name;
    public $type;
    /**
     * @var Address
     */
    public $address;

    public function __construct($id, $name, $type, Address $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->type = $type;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}
