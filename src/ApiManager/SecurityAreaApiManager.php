<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\ApiManager;

use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;

class SecurityAreaApiManager extends ApiEntityManager
{
    public function __construct($class, ObjectManager $om)
    {
        parent::__construct($class, $om);
    }
}
