<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\BasicsBundle\Controller\ResponseTrait;
use EHDev\FestivalBasicsBundle\Entity\SecurityArea;
use EHDev\FestivalBasicsBundle\Form\Type\SecurityAreaType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

#[Route('/security_area')]
class SecurityAreaController
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
     *      id="ehdev_festival_security_area_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     */
    #[Route('/', name: 'ehdev_festival_security_area_index')]
    public function indexAction(): Response
    {
        return $this->constructResponse([], '@EHDevFestivalBasics/SecurityArea/index.html.twig');
    }

    /**
     * @Acl(
     *      id="ehdev_festival_security_area_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     */
    #[Route('/create', name: 'ehdev_festival_security_area_create')]
    public function createAction(): Response
    {
        return $this->constructResponse(
            $this->update(new SecurityArea()),
            '@EHDevFestivalBasics/SecurityArea/update.html.twig',
        );
    }

    /**
     * @Acl(
     *      id="ehdev_festival_security_area_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     */
    #[Route('/update/{id}', name: 'ehdev_festival_security_area_update', requirements: ['id' => '\d+'])]
    public function updateAction(SecurityArea $entity): Response
    {
        return $this->constructResponse(
            $this->update($entity),
            '@EHDevFestivalBasics/SecurityArea/update.html.twig',
        );
    }

    protected function update(SecurityArea $entity): array|RedirectResponse
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(SecurityAreaType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.securityarea.saved.message')
        );
    }
}
