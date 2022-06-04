<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\BasicsBundle\Controller\ResponseTrait;
use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\DataObject\AddFestivalAccountDOT;
use EHDev\FestivalBasicsBundle\Form\FormHandler\FestivalAccountAddFestivalHandler;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalAccountAddFestivalType;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalAddFestivalAccountType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

#[Route('/add_festival')]
class AddFestivalToAccountController
{
    use ResponseTrait;

    public function __construct(
        private readonly UpdateHandlerFacade $updateHandlerFacade,
        private readonly TranslatorInterface $translator,
        private readonly FormFactoryInterface $formFactory,
        private readonly FestivalAccountAddFestivalHandler $accountAddFestivalHandler,
        /** @phpstan-ignore-next-line  */
        private readonly Environment $twig,
    ) {}

    /**
     * @AclAncestor("ehdev_festival_festival_account_update")
     */
    #[Route('/to_account/{id}', name: 'ehdev_festival_festival_account_add_festival', requirements: ['id' => '\d+'])]
    public function addFestivalAction(FestivalAccount $festivalAccount): Response
    {
        $model = new AddFestivalAccountDOT();
        $model->setFestivalAccount($festivalAccount);

        $response = $this->handle(
            $model,
            FestivalAccountAddFestivalType::class,
            'ehdev.festivalbasics.festivalaccount.form.add_festival.saved_message',
        );

        return $this->constructResponse(
            $response,
            '@EHDevFestivalBasics/AddFestivalToAccount/addFestival.html.twig',
            ['festivalAccount' => $festivalAccount],
        );
    }

    /**
     * @AclAncestor("ehdev_festival_festival_update")
     */
    #[Route('account/to_festival/{id}', name: 'ehdev_festival_festival_add_festival_account', requirements: ['id' => '\d+'])]
    public function addFestivalAccountAction(Festival $festival): Response
    {
        $model = new AddFestivalAccountDOT();
        $model->setFestival($festival);

        if ($festival->getFestivalAccount() instanceof FestivalAccount) {
            $model->setFestivalAccount($festival->getFestivalAccount());
        }

        $response = $this->handle(
            $model,
            FestivalAddFestivalAccountType::class,
            'ehdev.festivalbasics.festival.form.add_festivalaccount.saved_message',
        );

        return $this->constructResponse(
            $response,
            'EHDevFestivalBasicsBundle:AddFestivalToAccount:addFestivalAccount.html.twig',
            ['festival' => $festival],
        );
    }

    private function handle(AddFestivalAccountDOT $model, string $formType, string $saveMessage): array|RedirectResponse
    {
        return $this->updateHandlerFacade->update(
            $model,
            $this->formFactory->create($formType, $model),
            $this->translator->trans($saveMessage),
            null,
            $this->accountAddFestivalHandler,
        );
    }
}
