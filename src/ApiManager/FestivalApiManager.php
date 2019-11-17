<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\ApiManager;

use Doctrine\Common\Persistence\ObjectManager;
use EHDev\FestivalBasicsBundle\Entity\Festival;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;

class FestivalApiManager extends ApiEntityManager
{
    public function __construct(ObjectManager $om)
    {
        parent::__construct(Festival::class, $om);
    }
}
