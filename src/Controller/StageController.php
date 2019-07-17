<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\Stage;
use EHDev\FestivalBasicsBundle\Form\Type\StageType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/stage")
 */
class StageController
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
     * @Route("/", name="ehdev_festival_stage_index")
     * @Acl(
     *      id="ehdev_festival_stage_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     *
     * @Template
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/create", name="ehdev_festival_stage_create")
     * @Template("@EHDevFestivalBasics/Stage/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_stage_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     */
    public function createAction()
    {
        return $this->update(new Stage());
    }

    /**
     * @Route("/update/{id}", name="ehdev_festival_stage_update", requirements={"id"="\d+"})
     *
     * @Template
     * @Acl(
     *      id="ehdev_festival_stage_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     */
    public function updateAction(Stage $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param \EHDev\FestivalBasicsBundle\Entity\Stage $entity
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(Stage $entity)
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(StageType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.stage.saved.message')
        );
    }
}
