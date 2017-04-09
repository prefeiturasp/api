<?php

namespace SuperMae;

class Gestation implements \JsonSerializable
{
    /**
     * @var Establishment
     */
    public $establishment;
    /**
     * @var ChildbirthType
     */
    public $type;
    /**
     * @var Mother
     */
    public $mother;
    /**
     * @var \DateTime
     */
    public $birthday;
    /**
     * @var
     */
    public $gender;
    /**
     * @var
     */
    public $weigth;
    /**
     * @var
     */
    public $induced;
    /**
     * @var
     */
    public $cessionForced;

    public function __construct(
        Establishment $establishment,
        $type,
        Mother $mother,
        \DateTime $birthday,
        $gender,
        $weight,
        $induced,
        $cessionForced
    ) {
        $this->establishment = $establishment;
        $this->type = $type;
        $this->mother = $mother;
        $this->birthday = $birthday;
        $this->gender = $gender;
        $this->weigth = (int) $weight;
        $this->induced = (bool) $induced;
        $this->cessionForced = (bool) $cessionForced;
    }

    public function jsonSerialize()
    {
        $properties = get_object_vars($this);

        if ($properties['birthday'] instanceof \DateTime) {
            $properties['birthday'] = $properties['birthday']->format('Y-m-d');
        }

        if ($properties['gender']) {
            $properties['gender'] = (string) $properties['gender'];
        }

        if ($properties['type']) {
            $properties['type'] = (string) $properties['type'];
        }

        return $properties;
    }

}
