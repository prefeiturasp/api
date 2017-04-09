<?php

namespace SuperMae;

use SuperMae\Gestations\PelvicPresentation;

class Mother implements \JsonSerializable
{
    /**
     * @var int
     */
    public $age;
    /**
     * @var Pregnancy
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
    public $pelvicPresentation;
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
        PelvicPresentation $pelvicPresentation,
        $robsonClassification
    ) {
        $this->age = (int) $age;
        $this->pregnancy = $pregnancy;
        $this->totalCession = (int) $totalCession;
        $this->totalVaginal = (int) $totalVaginal;
        $this->numberOfWeek = (int) $numberOfWeek;
        $this->robsonClassification = (int) $robsonClassification;
        $this->pelvicPresentation = $pelvicPresentation;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
