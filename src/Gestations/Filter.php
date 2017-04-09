<?php

namespace SuperMae\Gestations;

use SuperMae\Gestations\Filter\AgeRange;

class Filter
{
    public $age;
    public $establishment;
    public $numberOfWeek;

    public function __construct(AgeRange $ageRange, $establishment, $numberOfWeek)
    {
        $this->age = $ageRange;
        $this->establishment = $establishment;
        $this->numberOfWeek = $numberOfWeek;
    }

    public function toArray()
    {
        $filter = [
            'mother.age' => [
                '$gte' => $this->age->start,
                '$lte' => $this->age->end
            ],
            'establishment.id' => $this->establishment,
            'mother.numberOfWeek' => $this->numberOfWeek,
        ];

        return array_filter($filter, function ($item) {
            return !empty($item);
        });
    }

    public function isNotEmpty()
    {
        $empty = new static(new AgeRange(null, null), null, null);

        return $empty != $this;
    }
}
