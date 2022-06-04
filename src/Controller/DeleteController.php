<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use EHDev\FestivalBasicsBundle\Entity\SecurityArea;
use EHDev\FestivalBasicsBundle\Entity\Stage;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/delete")
 */
class DeleteController extends Controller
{
    /**
     * @Route("/festival/{id}/", name="ehdev_festival_festival_delete")
     * @Method("DELETE")
     *
     * @Acl(
     *      id="ehdev_festival_festival_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="EHDevFestivalBasicsBundle:Festival"
     * )
     */
    public function deleteFestivalAction(Festival $festival): JsonResponse
    {
        $em = $this->getDoctrine()->getManagerForClass(Festival::class);
        $em->remove($festival);
        $em->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/festival_account/{id}/", name="ehdev_festival_festival_account_delete")
     * @Method("DELETE")
     *
     * @Acl(
     *      id="ehdev_festival_festival_account_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="EHDevFestivalBasicsBundle:FestivalAccount"
     * )
     */
    public function deleteFestivalAccountAction(FestivalAccount $festivalAccount): JsonResponse
    {
        $em = $this->getDoctrine()->getManagerForClass(FestivalAccount::class);
        $em->remove($festivalAccount);
        $em->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/security_area/{id}/", name="ehdev_festival_security_area_delete")
     * @Method("DELETE")
     *
     * @Acl(
     *      id="ehdev_festival_security_area_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     */
    public function deleteSecurityAreaAction(SecurityArea $securityArea): JsonResponse
    {
        $em = $this->getDoctrine()->getManagerForClass(SecurityArea::class);
        $em->remove($securityArea);
        $em->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/festival/{id}/", name="ehdev_festival_stage_delete")
     * @Method("DELETE")
     *
     * @Acl(
     *      id="ehdev_festival_stage_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="EHDevFestivalBasicsBundle:Stage"
     * )
     */
    public function deleteStageAction(Stage $stage): JsonResponse
    {
        $em = $this->getDoctrine()->getManagerForClass(Stage::class);
        $em->remove($stage);
        $em->flush();

        return new JsonResponse();
    }
}
