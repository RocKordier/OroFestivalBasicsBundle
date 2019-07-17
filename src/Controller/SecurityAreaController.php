<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\SecurityArea;
use EHDev\FestivalBasicsBundle\Form\Type\SecurityAreaType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/security_area")
 */
class SecurityAreaController
{
    private $updateHandlerFacade;
    private $translator;
    private $formFactory;

    public function __construct(
        UpdateHandlerFacade $updateHandlerFacade,
        TranslatorInterface $translator,
        FormFactoryInterface $formFactory
    ) {
        $this->updateHandlerFacade = $updateHandlerFacade;
        $this->translator = $translator;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/", name="ehdev_festival_security_area_index")
     * @Acl(
     *      id="ehdev_festival_security_area_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     *
     * @Template
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/create", name="ehdev_festival_security_area_create")
     * @Template("@EHDevFestivalBasics/SecurityArea/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_security_area_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     */
    public function createAction(): array
    {
        return $this->update(new SecurityArea());
    }

    /**
     * @Route("/update/{id}", name="ehdev_festival_security_area_update", requirements={"id"="\d+"})
     *
     * @Template
     * @Acl(
     *      id="ehdev_festival_security_area_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     */
    public function updateAction(SecurityArea $entity): array
    {
        return $this->update($entity);
    }

    protected function update(SecurityArea $entity): array
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(SecurityAreaType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.securityarea.saved.message')
        );
    }
}
