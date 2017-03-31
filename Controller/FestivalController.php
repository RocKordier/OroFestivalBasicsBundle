<?php

namespace EHDev\Bundle\FestivalBasicsBundle\Controller;

use EHDev\Bundle\FestivalBasicsBundle\Entity\Festival;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SecurityBundle\Annotation\Acl;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class FestivalController
 *
 * @package EHDev\Bundle\FestivalBasicsBundle\Controller
 * @Route("/festival")
 */
class FestivalController extends Controller
{
    /**
     * Index
     * @Route("/", name="ehdev_festival_festival_index")
     * @AclAncestor("ehdev_festival_festival_view")
     *
     * @Template
     */
    public function indexAction()
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
     * @param \EHDev\Bundle\FestivalBasicsBundle\Entity\Festival $festival
     */
    public function viewAction(Festival $festival)
    {
        return [
            'entity' => $festival,
        ];
    }

    /**
     * Create Festival
     *
     * @Route("/create", name="ehdev_festival_festival_create")
     * @Template("@EHDevFestivalBasics/Festival/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_festival_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     */
    public function createAction()
    {
        return $this->update($this->getManager()->createEntity());
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
     */
    public function updateAction(Festival $entity)
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
     * @param \EHDev\Bundle\FestivalBasicsBundle\Entity\Festival $festival
     *
     * @return array
     */
    public function infoAction(Festival $festival)
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
    public function stageAction(Festival $festival)
    {
        return [
            'entity' => $festival,
        ];
    }

    /**
     * @param \EHDev\Bundle\FestivalBasicsBundle\Entity\Festival $entity
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(Festival $entity)
    {
        return $this->get('oro_form.model.update_handler')->update(
            $entity,
            $this->get('ehdev.festival.form'),
            $this->get('translator')->trans('ehdev.festivalbasics.festival.saved.message')
        );
    }

    protected function getManager()
    {
        return $this->get('ehdev.festival.festival.manager');
    }
}
