<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalAccountType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/festival_account")
 */
class FestivalAccountController
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
     * @Route("/", name="ehdev_festival_festival_account_index")
     * @AclAncestor("ehdev_festival_festival_account_view")
     *
     * @Template
     */
    public function indexAction(): array
    {
        return [];
    }

    /**
     * @Route("/view/{id}", name="ehdev_festival_festival_account_view", requirements={"id"="\d+"})
     * @AclAncestor("ehdev_festival_festival_account_view")
     * @Template
     */
    public function viewAction(FestivalAccount $festivalAccount): array
    {
        return [
            'entity' => $festivalAccount,
        ];
    }

    /**
     * @Route("/widget/info/{id}", name="ehdev_festival_festival_aount_widget_info", requirements={"id"="\d+"})
     * @AclAncestor("ehdev_festival_festival_account_view")
     * @Template
     */
    public function infoAction(FestivalAccount $festivalAccount): array
    {
        return [
            'entity' => $festivalAccount,
        ];
    }

    /**
     * @Route("/create", name="ehdev_festival_festival_account_create")
     * @Template("@EHDevFestivalBasics/FestivalAccount/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_festival_account_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:FestivalAccount"
     * )
     */
    public function createAction(): array
    {
        return $this->update(new FestivalAccount());
    }

    /**
     * @Route("/update/{id}", name="ehdev_festival_festival_account_update", requirements={"id"="\d+"})
     *
     * @Template
     * @Acl(
     *      id="ehdev_festival_festival_account_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:FestivalAccout"
     * )
     */
    public function updateAction(FestivalAccount $entity): array
    {
        return $this->update($entity);
    }

    protected function update(FestivalAccount $entity): array
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(FestivalAccountType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.festivalaccount.saved.message')
        );
    }
}
