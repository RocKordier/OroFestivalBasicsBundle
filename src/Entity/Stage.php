<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendStage;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\OrganizationBundle\Entity\Ownership\BusinessUnitAwareTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="EHDev\FestivalBasicsBundle\Entity\Repository\StageRepository")
 * @ORM\Table(name="ehdev_fwb_stage")
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-flask"},
 *  "grid"={"default"="ehdev-festival-stage-grid"},
 *  "tag"={"enabled"=true},
 *  "security"={
 *      "type"="ACL",
 *      "group_name"="",
 *      "category"="ehdev_festival_stage"
 *  },
 *  "ownership"={
 *    "owner_type"="BUSINESS_UNIT",
 *    "owner_field_name"="owner",
 *    "owner_column_name"="business_unit_owner_id",
 *    "organization_field_name"="organization",
 *    "organization_column_name"="organization_id"
 *  }
 * })
 */
class Stage extends ExtendStage
{
    use BusinessUnitAwareTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var Festival
     *
     * @ORM\ManyToOne(targetEntity="Festival", inversedBy="stages")
     * @ORM\JoinColumn(name="festival_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    protected $festival;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Festival
     */
    public function getFestival()
    {
        return $this->festival;
    }

    /**
     * @return self
     */
    public function setFestival(Festival $festival)
    {
        $this->festival = $festival;

        return $this;
    }
}
