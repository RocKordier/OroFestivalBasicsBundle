<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\AutocompleteHandler;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use Oro\Bundle\FormBundle\Autocomplete\SearchHandler;

class FestivalSearchHandler extends SearchHandler
{
    public function __construct()
    {
        parent::__construct(Festival::class, ['name']);
    }
}
