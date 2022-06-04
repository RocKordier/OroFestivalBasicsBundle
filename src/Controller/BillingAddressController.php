<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\BasicsBundle\Controller\ResponseTrait;
use EHDev\FestivalBasicsBundle\Entity\BillingAddress;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\Type\BillingAddressType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

#[Route('/festival_account/billing_address')]
class BillingAddressController
{
    use ResponseTrait;

    public function __construct(
        private readonly UpdateHandlerFacade $updateHandlerFacade,
        private readonly TranslatorInterface $translator,
        private readonly FormFactoryInterface $formFactory,
        /** @phpstan-ignore-next-line  */
        private readonly Environment $twig,
    ) {}

    /**
     * @AclAncestor("ehdev_festival_billing_address_update")
     */
    #[Route('{id}/create', name: 'ehdev_festival_billingaddress_create')]
    public function createAction(FestivalAccount $festivalAccount): Response
    {
        $billingAddress = new BillingAddress($festivalAccount);

        if ($festivalAccount->getBillingAddress() instanceof BillingAddress) {
            $billingAddress = $festivalAccount->getBillingAddress();
        }

        return $this->update($billingAddress);
    }

    /**
     * @Acl(
     *      id="ehdev_festival_billing_address_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:BillingAddress"
     * )
     */
    #[Route('/update/{id}', name: 'ehdev_festival_billingaddress_update', requirements: ['id' => '\d+'])]
    public function updateAction(BillingAddress $entity): Response
    {
        return $this->update($entity);
    }

    protected function update(BillingAddress $entity): Response
    {
        $response = $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(BillingAddressType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.billingaddress.saved.message')
        );

        return $this->constructResponse(
            $response,
            'EHDevFestivalBasicsBundle:BillingAddress:update.html.twig',
            ['festivalAccount' => $entity->getOwner()],
        );
    }
}
