<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\DataObject;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;

final class AddFestivalAccountDOT
{
    /**
     * @var int|null
     */
    public $id = null;

    /**
     * @var Festival|null
     */
    private $festival = null;

    /**
     * @var FestivalAccount|null
     */
    private $festivalAccount = null;

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(Festival $festival): void
    {
        $this->festival = $festival;

        if (isset($this->festivalAccount)) {
            $this->festivalAccount->addFestival($festival);

            $this->id = 1;
        }
    }

    public function getFestivalAccount(): ?FestivalAccount
    {
        return $this->festivalAccount;
    }

    public function setFestivalAccount(FestivalAccount $festivalAccount): void
    {
        $this->festivalAccount = $festivalAccount;

        if (isset($this->festival)) {
            $this->festivalAccount->addFestival($this->festival);

            $this->id = 1;
        }
    }
}
