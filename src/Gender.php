<?php

namespace SuperMae;

class Gender
{
    const FEMALE = 'F';
    const MALE = 'M';

    private $labels = [
        Gender::FEMALE => 'female',
        Gender::MALE => 'male',
    ];

    public $gender;

    public function __construct($gender)
    {
        if (!in_array($gender, array_keys($this->labels))) {
            throw new \DOMException('Gender not found');
        }

        $this->gender = $gender;
    }

    public function __toString()
    {
        return (string) $this->labels[$this->gender];
    }
}
