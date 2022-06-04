<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\EventListener;

use Doctrine\ORM\EntityManager;
use EHDev\FestivalBasicsBundle\Entity\Festival;
use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractFestivalDetailViewListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly TranslatorInterface $translator,
        private readonly EntityManager $entityManager
    ) {}

    public function getFestival(): Festival
    {
        if (!($this->requestStack->getCurrentRequest() instanceof Request)) {
            throw new BadRequestHttpException('current request does not exist');
        }

        $festival = $this->requestStack->getCurrentRequest()->get('festival');
        if ($festival instanceof Festival) {
            return $festival;
        }

        throw new MissingMandatoryParametersException('Festival not found in current request');
    }

    protected function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    protected function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    abstract public function onView(BeforeListRenderEvent $event): void;
}
