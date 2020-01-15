<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\BillingAddress;
use EHDev\FestivalBasicsBundle\Entity\Contact;
use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\Type\ContactType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/festival_account/contact")
 */
class ContactController
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
     * @Route("/create/{id}", name="ehdev_festival_contact_create", requirements={"id"="\d+"})
     *
     * @Template("@EHDevFestivalBasics/FestivalContact/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_contact_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:Contact"
     * )
     */
    public function createAction(FestivalAccount $festivalAccount): array
    {
        return array_merge($this->update(new Contact($festivalAccount)), ['iscreate' => true]);
    }

    /**
     * @Route("/view/{id}", name="ehdev_festival_contact_view", requirements={"id"="\d+"})
     * @Template("@EHDevFestivalBasics/FestivalContact/info.html.twig")
     * @Acl(
     *      id="ehdev_festival_contact_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:Contact"
     * )
     */
    public function viewContactAction(Contact $contact): array
    {
        return ['contact' => $contact];
    }

    /**
     * @Route("/update/{id}", name="ehdev_festival_contact_update", requirements={"id"="\d+"})
     *
     * @Template("@EHDevFestivalBasics/FestivalContact/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_contact_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:Contact"
     * )
     */
    public function updateAction(Contact $entity): array
    {
        return $this->update($entity);
    }

    protected function update(Contact $entity): array
    {
        return array_merge(
            $this->updateHandlerFacade->update(
                $entity,
                $this->formFactory->create(ContactType::class, $entity),
                $this->translator->trans('ehdev.festivalbasics.contact.saved.message')
            ),
            ['festivalAccount' => $entity->getOwner()]
        );
    }
}
