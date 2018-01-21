<?php
namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\SecurityArea;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oro\Bundle\SecurityBundle\Annotation\Acl;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/security_area")
 */
class SecurityAreaController extends Controller
{
    /**
     * @Route("/", name="ehdev_festival_security_area_index")
     * @Acl(
     *      id="ehdev_festival_security_area_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     *
     * @Template
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/create", name="ehdev_festival_security_area_create")
     * @Template("@EHDevFestivalBasics/SEcurityArea/update.html.twig")
     * @Acl(
     *      id="ehdev_festival_security_area_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     */
    public function createAction(): array
    {
        return $this->update($this->getManager()->createEntity());
    }

    /**
     * @Route("/update/{id}", name="ehdev_festival_security_area_update", requirements={"id"="\d+"})
     *
     * @Template
     * @Acl(
     *      id="ehdev_festival_security_area_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     */
    public function updateAction(SecurityArea $entity): array
    {
        return $this->update($entity);
    }

    protected function update(SecurityArea $entity): array
    {
        return $this->get('oro_form.model.update_handler')->update(
            $entity,
            $this->get('ehdev.securityarea.form'),
            $this->get('translator')->trans('ehdev.festivalbasics.securityarea.saved.message')
        );
    }

    private function getManager()
    {
        return $this->get('ehdev.festival.security_area.manager');
    }
}
