<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\BillingAddress;
use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\Type\BillingAddressType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/festival_account/billing_address")
 */
class BillingAddressController
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
     * @Route("{id}/create", name="ehdev_festival_billingaddress_create")
     * @Template("@EHDevFestivalBasics/BillingAddress/update.html.twig")
     * @AclAncestor("ehdev_festival_billing_address_update")
     */
    public function createAction(FestivalAccount $festivalAccount): array
    {
        $billingAddress = new BillingAddress($festivalAccount);

        if ($festivalAccount->getBillingAddress() instanceof BillingAddress) {
            $billingAddress = $festivalAccount->getBillingAddress();
        }

        return $this->update($billingAddress);
    }

    /**
     * @Route("/update/{id}", name="ehdev_festival_billingaddress_update", requirements={"id"="\d+"})
     *
     * @Template
     * @Acl(
     *      id="ehdev_festival_billing_address_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:BillingAddress"
     * )
     */
    public function updateAction(BillingAddress $entity): array
    {
        return $this->update($entity);
    }

    protected function update(BillingAddress $entity): array
    {
        return array_merge(
            $this->updateHandlerFacade->update(
                $entity,
                $this->formFactory->create(BillingAddressType::class, $entity),
                $this->translator->trans('ehdev.festivalbasics.billingaddress.saved.message')
            ),
            ['festivalAccont' => $entity->getOwner()]
        );
    }
}
