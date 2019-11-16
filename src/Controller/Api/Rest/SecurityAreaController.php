<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Controller\Api\Rest;

use EHDev\FestivalBasicsBundle\ApiManager\SecurityAreaApiManager;
use EHDev\FestivalBasicsBundle\Entity\SecurityArea;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * @RouteResource("security_area")
 * @NamePrefix("oro_api_")
 */
class SecurityAreaController extends RestController implements ClassResourceInterface
{
    private $apiManager;

    public function __construct(SecurityAreaApiManager $manager)
    {
        $this->apiManager = $manager;
    }

    /**
     * REST DELETE.
     *
     * @param int $id
     *
     * @ApiDoc(
     *      description="Delete Security Area",
     *      resource=true
     * )
     * @Acl(
     *      id="ehdev_festival_security_area_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="EHDevFestivalBasicsBundle:SecurityArea"
     * )
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }

    public function getManager(): ApiEntityManager
    {
        return $this->apiManager;
    }

    public function getForm()
    {
        throw new \BadMethodCallException('Form is not available.');
    }

    public function getFormHandler()
    {
        throw new \BadMethodCallException('FormHandler is not available.');
    }
}
