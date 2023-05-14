<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\BasicsBundle\Controller\ResponseTrait;
use EHDev\FestivalBasicsBundle\Entity\Contact;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\Type\ContactType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

#[Route('/festival_account/contact')]
class ContactController
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
     * @Acl(
     *      id="ehdev_festival_contact_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:Contact"
     * )
     */
    #[Route('/create/{id}', name: 'ehdev_festival_contact_create', requirements: ['id' => '\d+'])]
    public function createAction(FestivalAccount $festivalAccount): Response
    {
        $response = $this->update(new Contact($festivalAccount));

        return $this->constructResponse(
            $response,
            '@EHDevFestivalBasics/FestivalContact/update.html.twig',
            ['iscreate' => true, 'festivalAccount' => $festivalAccount],
        );
    }

    /**
     * @Acl(
     *      id="ehdev_festival_contact_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:Contact"
     * )
     */
    #[Route('/view/{id}', name: 'ehdev_festival_contact_view', requirements: ['id' => '\d+'])]
    public function viewContactAction(Contact $contact): Response
    {
        return $this->constructResponse(
            ['contact' => $contact, 'festivalAccount' => $contact->getOwner()],
            '@EHDevFestivalBasics/FestivalContact/info.html.twig',
        );
    }

    /**
     * @Acl(
     *      id="ehdev_festival_contact_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:Contact"
     * )
     */
    #[Route('/update/{id}', name: 'ehdev_festival_contact_update', requirements: ['id' => '\d+'])]
    public function updateAction(Contact $entity): Response
    {
        return $this->constructResponse(
            $this->update($entity),
            '@EHDevFestivalBasics/FestivalContact/update.html.twig',
        );
    }

    protected function update(Contact $entity): array|RedirectResponse
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(ContactType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.contact.saved.message'),
        );
    }
}
