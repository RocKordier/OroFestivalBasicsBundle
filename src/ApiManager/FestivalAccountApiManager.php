<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\ApiManager;

use Doctrine\Common\Persistence\ObjectManager;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;

class FestivalAccountApiManager extends ApiEntityManager
{
    public function __construct(ObjectManager $om)
    {
        parent::__construct(FestivalAccount::class, $om);
    }
}
