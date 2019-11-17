<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\AutocompleteHandler;

use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use Oro\Bundle\FormBundle\Autocomplete\SearchHandler;

class FestivalAccountSearchHandler extends SearchHandler
{
    public function __construct()
    {
        parent::__construct(FestivalAccount::class, ['name']);
    }
}
