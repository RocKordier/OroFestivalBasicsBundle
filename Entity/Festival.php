<?php

namespace EHDev\Bundle\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\Bundle\BasicsBundle\Entity\Traits\BUOwnerTrait;
use EHDev\Bundle\FestivalBasicsBundle\Model\ExtendFestival;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;

/**
 * Class Festival
 *
 * @ORM\Entity(repositoryClass="EHDev\Bundle\FestivalBasicsBundle\Entity\Repository\FestivalRepository")
 * @ORM\Table(name="ehdev_fwb_festival")
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-th-list"},
 *  "grid"={"default"="ehdev-festival-festival-grid"},
 *  "form"= {"grid_name"="ehdev-festival-festival-grid"},
 *  "tag"={"enabled"=true},
 *  "security"={
 *      "type"="ACL",
 *      "group_name"="",
 *      "category"="ehdev_festival_festival"
 *  },
 *  "ownership"={
 *    "owner_type"="BUSINESS_UNIT",
 *    "owner_field_name"="owner",
 *    "owner_column_name"="business_unit_owner_id",
 *    "organization_field_name"="organization",
 *    "organization_column_name"="organization_id"
 *  }
 * })
 *
 * @package EHDev\Bundle\FestivalBasicsBundle\Entity
 */
class Festival extends ExtendFestival
{
    use BUOwnerTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var \DateTime $created
     * @ORM\Column(type="datetime", name="start_date")
     */
    protected $startDate;

    /**
     * @var \DateTime $created
     * @ORM\Column(type="datetime", name="end_date")
     */
    protected $endDate;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $maxGuests;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(
     *      targetEntity="EHDev\Bundle\FestivalBasicsBundle\Entity\Stage", mappedBy="festival",
     *      cascade={"all"}, orphanRemoval=true
     * )
     */
    protected $stages;

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
     * @return Festival
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return Festival
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return Festival
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxGuests()
    {
        return $this->maxGuests;
    }

    /**
     * @param int $maxGuests
     *
     * @return Festival
     */
    public function setMaxGuests($maxGuests)
    {
        $this->maxGuests = $maxGuests;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * @param \EHDev\Bundle\FestivalBasicsBundle\Entity\Stage $stage
     */
    public function addStage(Stage $stage)
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
        }
    }

    /**
     * @param \EHDev\Bundle\FestivalBasicsBundle\Entity\Stage $stage
     */
    public function removeStage(Stage $stage)
    {
        $this->stages->removeElement($stage);
    }
}
