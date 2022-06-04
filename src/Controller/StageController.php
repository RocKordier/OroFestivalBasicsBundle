<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\BasicsBundle\Controller\ResponseTrait;
use EHDev\FestivalBasicsBundle\Entity\Stage;
use EHDev\FestivalBasicsBundle\Form\Type\StageType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

#[Route('/stage')]
class StageController
{
    use ResponseTrait;

    public function __construct(
        private readonly UpdateHandlerFacade $updateHandlerFacade,
        private readonly TranslatorInterface $translator,
        private readonly FormFactoryInterface $formFactory,
        /** @phpstan-ignore-next-line */
        private readonly Environment $twig,
    ) {}

    /**
     * @Acl(
     *      id="ehdev_festival_stage_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     */
    #[Route('/', name: 'ehdev_festival_stage_index')]
    public function indexAction(): Response
    {
        return $this->constructResponse([], '@EHDevFestivalBasics/Stage/index.html.twig');
    }

    /**
     * @Acl(
     *      id="ehdev_festival_stage_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     */
    #[Route('/create', name: 'ehdev_festival_stage_create')]
    public function createAction(): Response
    {
        return $this->constructResponse(
            $this->update(new Stage()),
            '@EHDevFestivalBasics/Stage/update.html.twig',
        );
    }

    /**
     * @Acl(
     *      id="ehdev_festival_stage_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     */
    #[Route('/update/{id}', name: 'ehdev_festival_stage_update', requirements: ['id' => '\d+'])]
    public function updateAction(Stage $entity): Response
    {
        return $this->constructResponse(
            $this->update($entity),
            '@EHDevFestivalBasics/Stage/update.html.twig',
        );
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
