<?php

namespace SuperMae;

class Mother implements \JsonSerializable
{
    /**
     * @var int
     */
    public $age;
    /**
     * @var int
     */
    public $pregnancy;
    /**
     * @var
     */
    public $totalCession;
    /**
     * @var
     */
    public $totalVaginal;
    /**
     * @var
     */
    public $numberOfWeek;
    /**
     * @var
     */
    public $robsonClassification;

    public function __construct(
        $age,
        $pregnancy,
        $totalCession,
        $totalVaginal,
        $numberOfWeek,
        $robsonClassification
    ) {
        $this->age = (int) $age;
        $this->pregnancy = $pregnancy;
        $this->totalCession = (int) $totalCession;
        $this->totalVaginal = (int) $totalVaginal;
        $this->numberOfWeek = (int) $numberOfWeek;
        $this->robsonClassification = (int) $robsonClassification;
    }

    public function jsonSerialize()
    {
        $properties = get_object_vars($this);

        if ($properties['pregnancy']) {
            $properties['pregnancy'] = (string) $properties['pregnancy'];
        }

        return $properties;
    }
}
