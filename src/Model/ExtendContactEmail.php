<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Model;

use Oro\Bundle\AddressBundle\Entity\AbstractEmail;

class ExtendContactEmail extends AbstractEmail
{
    public function __construct(?string $eMail)
    {
        parent::__construct($eMail);
    }
}
