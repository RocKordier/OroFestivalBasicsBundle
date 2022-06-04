<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\Stage;
use EHDev\FestivalBasicsBundle\Form\Type\StageType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/stage")
 */
class StageController
{
    public function __construct(
        private readonly UpdateHandlerFacade $updateHandlerFacade,
        private readonly TranslatorInterface $translator,
        private readonly FormFactoryInterface $formFactory
    ) {}

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
    public function indexAction(): array
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
    public function createAction(): array|RedirectResponse
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
    public function updateAction(Stage $entity): array|RedirectResponse
    {
        return $this->update($entity);
    }

    protected function update(Stage $entity): array|RedirectResponse
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(StageType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.stage.saved.message')
        );
    }
}
