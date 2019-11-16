<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/festival")
 */
class FestivalController
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
     * @Route("/", name="ehdev_festival_festival_index")
     * @AclAncestor("ehdev_festival_festival_view")
     *
     * @Template
     */
    public function indexAction(): array
    {
        return [];
    }

    /**
     * @Route("/view/{id}", name="ehdev_festival_festival_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="ehdev_festival_festival_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     */
    public function viewAction(Festival $festival): array
    {
        return [
            'entity' => $festival,
        ];
    }

    /**
     * @Route("/create", name="ehdev_festival_festival_create")
     * @Template("@EHDevFestivalBasics/Festival/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_festival_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     */
    public function createAction(): array
    {
        return $this->update(new Festival());
    }

    /**
     * @Route("/update/{id}", name="ehdev_festival_festival_update", requirements={"id"="\d+"})
     *
     * @Template
     * @Acl(
     *      id="ehdev_festival_festival_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     */
    public function updateAction(Festival $entity): array
    {
        return $this->update($entity);
    }

    /**
     * @Route("/widget/info/{id}", name="ehdev_festival_festival_widget_info", requirements={"id"="\d+"})
     * @AclAncestor("ehdev_festival_festival_view")
     * @Template
     */
    public function infoAction(Festival $festival): array
    {
        return [
            'entity' => $festival,
        ];
    }

    /**
     * @Route("/widget/stages/{id}", name="ehdev_festival_festival_widget_stages", requirements={"id"="\d+"})
     * @AclAncestor("ehdev_festival_festival_view")
     * @Template
     */
    public function stageAction(Festival $festival): array
    {
        return [
            'entity' => $festival,
        ];
    }

    protected function update(Festival $entity): array
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(FestivalType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.festival.saved.message')
        );
    }
}
