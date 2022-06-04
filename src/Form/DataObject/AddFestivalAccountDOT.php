<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\DataObject;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;

final class AddFestivalAccountDOT
{
    public ?int $id = null;

    private ?Festival $festival = null;

    private ?FestivalAccount $festivalAccount = null;

    public function getId(): ?int
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
