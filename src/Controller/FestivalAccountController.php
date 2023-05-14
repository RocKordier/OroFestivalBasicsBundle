<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\BasicsBundle\Controller\ResponseTrait;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalAccountType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

#[Route('/festival_account')]
class FestivalAccountController
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
     * @AclAncestor("ehdev_festival_festival_account_view")
     */
    #[Route('/', name: 'ehdev_festival_festival_account_index')]
    public function indexAction(): Response
    {
        return $this->constructResponse([], '@EHDevFestivalBasics/FestivalAccount/index.html.twig');
    }

    /**
     * @AclAncestor("ehdev_festival_festival_account_view")
     */
    #[Route('/view/{id}', name: 'ehdev_festival_festival_account_view', requirements: ['id' => '\d+'])]
    public function viewAction(FestivalAccount $festivalAccount): Response
    {
        return $this->constructResponse(
            ['entity' => $festivalAccount],
            '@EHDevFestivalBasics/FestivalAccount/view.html.twig',
        );
    }

    /**
     * @AclAncestor("ehdev_festival_festival_account_view")
     */
    #[Route('/widget/festivals/{id}', name: 'ehdev_festival_festival_account_widget_festivals', requirements: ['id' => '\d+'])]
    public function festivalsAction(FestivalAccount $festivalAccount): Response
    {
        return $this->constructResponse(
            ['entity' => $festivalAccount],
            '@EHDevFestivalBasics/FestivalAccount/widget/festivals.html.twig',
        );
    }

    /**
     * @Acl(
     *      id="ehdev_festival_festival_account_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:FestivalAccount"
     * )
     */
    #[Route('/create', name: 'ehdev_festival_festival_account_create')]
    public function createAction(): Response
    {
        return $this->constructResponse(
            $this->update(new FestivalAccount()),
            '@EHDevFestivalBasics/FestivalAccount/update.html.twig',
        );
    }

    /**
     * @Acl(
     *      id="ehdev_festival_festival_account_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:FestivalAccount"
     * )
     */
    #[Route('/update/{id}', name: 'ehdev_festival_festival_account_update', requirements: ['id' => '\d+'])]
    public function updateAction(FestivalAccount $entity): Response
    {
        return $this->constructResponse(
            $this->update($entity),
            '@EHDevFestivalBasics/FestivalAccount/update.html.twig',
        );
    }

    protected function update(FestivalAccount $entity): array|RedirectResponse
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(FestivalAccountType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.festivalaccount.saved.message')
        );
    }
}
