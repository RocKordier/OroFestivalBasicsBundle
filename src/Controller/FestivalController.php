<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\BasicsBundle\Controller\ResponseTrait;
use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

#[Route('/festival')]
class FestivalController
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
     * @AclAncestor("ehdev_festival_festival_view")
     */
    #[Route('/', name: 'ehdev_festival_festival_index')]
    public function indexAction(): Response
    {
        return $this->constructResponse([], '@EHDevFestivalBasics/Festival/index.html.twig');
    }

    /**
     * @Acl(
     *      id="ehdev_festival_festival_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     */
    #[Route('/view/{id}', name: 'ehdev_festival_festival_view', requirements: ['id' => '\d+'])]
    public function viewAction(Festival $festival): Response
    {
        return $this->constructResponse(
            ['entity' => $festival],
            '@EHDevFestivalBasics/Festival/view.html.twig',
        );
    }

    /**
     * @Acl(
     *      id="ehdev_festival_festival_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     */
    #[Route('/create', name: 'ehdev_festival_festival_create')]
    public function createAction(): Response
    {
        return $this->constructResponse(
            $this->update(new Festival()),
            '@EHDevFestivalBasics/Festival/update.html.twig',
        );
    }

    /**
     * @Acl(
     *      id="ehdev_festival_festival_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     */
    #[Route('/update/{id}', name: 'ehdev_festival_festival_update', requirements: ['id' => '\d+'])]
    public function updateAction(Festival $entity): Response
    {
        return $this->constructResponse(
            $this->update($entity),
            '@EHDevFestivalBasics/Festival/update.html.twig',
        );
    }

    /**
     * @AclAncestor("ehdev_festival_festival_view")
     */
    #[Route('/widget/info/{id}', name: 'ehdev_festival_festival_widget_info', requirements: ['id' => '\d+'])]
    public function infoAction(Festival $festival): Response
    {
        return $this->constructResponse(
            ['entity' => $festival],
            '@EHDevFestivalBasics/Festival/widget/info.html.twig',
        );
    }

    /**
     * @AclAncestor("ehdev_festival_festival_view")
     */
    #[Route('/widget/stages/{id}', name: 'ehdev_festival_festival_widget_stages', requirements: ['id' => '\d+'])]
    public function stageAction(Festival $festival): Response
    {
        return $this->constructResponse(
            ['entity' => $festival],
            '@EHDevFestivalBasics/Festival/widget/stage.html.twig',
        );
    }

    protected function update(Festival $entity): array|RedirectResponse
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(FestivalType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.festival.saved.message')
        );
    }
}
