<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\DataObject\AddFestivalAccountDOT;
use EHDev\FestivalBasicsBundle\Form\FormHandler\FestivalAccountAddFestivalHandler;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalAccountAddFestivalType;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalAddFestivalAccountType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/add_festival")
 */
class AddFestivalToAccountController
{
    public function __construct(
        private readonly UpdateHandlerFacade $updateHandlerFacade,
        private readonly TranslatorInterface $translator,
        private readonly FormFactoryInterface $formFactory,
        private readonly FestivalAccountAddFestivalHandler $accountAddFestivalHandler
    ) {}

    /**
     * @Route("/to_account/{id}", name="ehdev_festival_festival_account_add_festival", requirements={"id"="\d+"})
     *
     * @Template()
     * @AclAncestor("ehdev_festival_festival_account_update")
     */
    public function addFestivalAction(FestivalAccount $festivalAccount): array|RedirectResponse
    {
        $model = new AddFestivalAccountDOT();
        $model->setFestivalAccount($festivalAccount);

        $response = $this->handle(
            $model,
            FestivalAccountAddFestivalType::class,
            'ehdev.festivalbasics.festivalaccount.form.add_festival.saved_message'
        );

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        return array_merge($response, ['festivalAccount' => $festivalAccount]);
    }

    /**
     * @Route("account/to_festival/{id}", name="ehdev_festival_festival_add_festival_account", requirements={"id"="\d+"})
     *
     * @Template()
     * @AclAncestor("ehdev_festival_festival_update")
     */
    public function addFestivalAccountAction(Festival $festival): array|RedirectResponse
    {
        $model = new AddFestivalAccountDOT();
        $model->setFestival($festival);

        if ($festival->getFestivalAccount() instanceof FestivalAccount) {
            $model->setFestivalAccount($festival->getFestivalAccount());
        }

        $response = $this->handle(
            $model,
            FestivalAddFestivalAccountType::class,
            'ehdev.festivalbasics.festival.form.add_festivalaccount.saved_message'
        );

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        return array_merge($response, ['festival' => $festival]);
    }

    private function handle(AddFestivalAccountDOT $model, string $formType, string $saveMessage): array|RedirectResponse
    {
        return $this->updateHandlerFacade->update(
            $model,
            $this->formFactory->create($formType, $model),
            $this->translator->trans($saveMessage),
            null,
            $this->accountAddFestivalHandler
        );
    }
}
