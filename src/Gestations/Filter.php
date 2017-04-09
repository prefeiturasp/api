<?php

namespace SuperMae\Gestations;

class Filter
{
    public $age;
    public $establishment;
    public $numberOfWeek;

    public function __construct($age, $establishment, $numberOfWeek)
    {
        $this->age = $age;
        $this->establishment = $establishment;
        $this->numberOfWeek = $numberOfWeek;
    }

    public function toArray()
    {
        $filter = [
            'mother.age' => $this->age,
            'establishment.id' => $this->establishment,
            'mother.numberOfWeek' => $this->numberOfWeek,
        ];
        return array_filter($filter, function ($item) {
            return !empty($item);
        });
    }

    public function isNotEmpty()
    {
        return new static(null, null, null) != $this;
    }
}
