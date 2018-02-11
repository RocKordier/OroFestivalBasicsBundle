<?php
namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oro\Bundle\SecurityBundle\Annotation\Acl;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/stage")
 */
class StageController extends Controller
{
    /**
     * Index
     * @Route("/", name="ehdev_festival_stage_index")
     * @Acl(
     *      id="ehdev_festival_stage_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     *
     * @Template
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * Create Stage
     *
     * @Route("/create", name="ehdev_festival_stage_create")
     * @Template("@EHDevFestivalBasics/Stage/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_stage_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     */
    public function createAction()
    {
        return $this->update($this->getManager()->createEntity());
    }

    /**
     * Update Stage
     * @Route("/update/{id}", name="ehdev_festival_stage_update", requirements={"id"="\d+"})
     *
     * @Template
     * @Acl(
     *      id="ehdev_festival_stage_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     */
    public function updateAction(Stage $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param \EHDev\FestivalBasicsBundle\Entity\Stage $entity
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(Stage $entity)
    {
        return $this->get('oro_form.update_handler')->update(
            $entity,
            $this->get('ehdev.stage.form'),
            $this->get('translator')->trans('ehdev.festivalbasics.stage.saved.message')
        );
    }

    protected function getManager()
    {
        return $this->get('ehdev.festival.stage.manager');
    }
}
