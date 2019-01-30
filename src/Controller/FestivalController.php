<?php
namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Form\Type\FestivalType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SecurityBundle\Annotation\Acl;

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
     * Index
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
     *
     * @param \EHDev\FestivalBasicsBundle\Entity\Festival $festival
     * @return array
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
     * Update festival form
     * @Route("/update/{id}", name="ehdev_festival_festival_update", requirements={"id"="\d+"})
     *
     * @Template
     * @Acl(
     *      id="ehdev_festival_festival_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     *
     * @param \EHDev\FestivalBasicsBundle\Entity\Festival $entity
     * @return array
     *
     */
    public function updateAction(Festival $entity): array
    {
        return $this->update($entity);
    }

    /**
     * Info
     *
     * @Route("/widget/info/{id}", name="ehdev_festival_festival_widget_info", requirements={"id"="\d+"})
     * @AclAncestor("ehdev_festival_festival_view")
     * @Template
     *
     * @param \EHDev\FestivalBasicsBundle\Entity\Festival $festival
     *
     * @return array
     */
    public function infoAction(Festival $festival): array
    {
        return [
            'entity' => $festival,
        ];
    }

    /**
     * Stage widget
     *
     * @Route("/widget/stages/{id}", name="ehdev_festival_festival_widget_stages", requirements={"id"="\d+"})
     * @AclAncestor("ehdev_festival_festival_view")
     * @Template
     *
     * @param Festival $festival
     *
     * @return array
     */
    public function stageAction(Festival $festival): array
    {
        return [
            'entity' => $festival,
        ];
    }

    /**
     * @param \EHDev\FestivalBasicsBundle\Entity\Festival $entity
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(Festival $entity): array
    {
        return $this->updateHandlerFacade->update(
            $entity,
            $this->formFactory->create(FestivalType::class, $entity),
            $this->translator->trans('ehdev.festivalbasics.festival.saved.message')
        );
    }
}
