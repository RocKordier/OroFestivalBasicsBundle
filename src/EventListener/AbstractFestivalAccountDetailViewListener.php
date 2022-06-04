<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\EventListener;

use Doctrine\ORM\EntityManager;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractFestivalAccountDetailViewListener
{
    /** @var RequestStack */
    protected $requestStack;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var EntityManager */
    protected $entityManager;

    /**
     * AbstractFestivalDetailViewListener constructor.
     */
    public function __construct(
        RequestStack $requestStack,
        TranslatorInterface $translator,
        EntityManager $entityManager
    ) {
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->entityManager = $entityManager;
    }

    public function getFestivalAccount(): FestivalAccount
    {
        if (!($this->requestStack->getCurrentRequest() instanceof Request)) {
            throw new BadRequestHttpException('current request does not exist');
        }

        $festivalAccount = $this->requestStack->getCurrentRequest()->get('festivalAccount');
        if ($festivalAccount instanceof FestivalAccount) {
            return $festivalAccount;
        }

        throw new MissingMandatoryParametersException('Festival not found in current request');
    }

    abstract public function onView(BeforeListRenderEvent $event);
}
