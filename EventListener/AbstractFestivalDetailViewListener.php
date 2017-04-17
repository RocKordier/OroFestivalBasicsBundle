<?php

namespace EHDev\Bundle\FestivalBasicsBundle\EventListener;

use Doctrine\ORM\EntityManager;
use EHDev\Bundle\FestivalBasicsBundle\Entity\Festival;
use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class AbstractFestivalDetailViewListener
 *
 * @package EHDev\Bundle\FestivalBasicsBundle\EventListener
 */
abstract class AbstractFestivalDetailViewListener
{
    /** @var RequestStack */
    protected $requestStack;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var  EntityManager */
    protected $entityManager;

    /**
     * AbstractFestivalDetailViewListener constructor.
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack     $requestStack
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     * @param \Doctrine\ORM\EntityManager                        $entityManager
     */
    public function __construct(
        RequestStack $requestStack,
        TranslatorInterface $translator,
        EntityManager $entityManager
    ) {
        $this->requestStack  = $requestStack;
        $this->translator    = $translator;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Festival
     */
    public function getFestival()
    {
        return $this->requestStack->getCurrentRequest()->get('festival');
    }

    abstract public function onView(BeforeListRenderEvent $event);
}
