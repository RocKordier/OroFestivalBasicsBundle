<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendFestival;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\OrganizationBundle\Entity\Ownership\BusinessUnitAwareTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="EHDev\FestivalBasicsBundle\Entity\Repository\FestivalRepository")
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
 */
class Festival extends ExtendFestival
{
    use BusinessUnitAwareTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="start_date")
     * @Assert\NotBlank()
     */
    protected $startDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="end_date")
     * @Assert\NotBlank()
     */
    protected $endDate;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     */
    protected $maxGuests;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(
     *      targetEntity="EHDev\FestivalBasicsBundle\Entity\Stage", mappedBy="festival",
     *      cascade={"all"}, orphanRemoval=true
     * )
     */
    protected $stages;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="is_active")
     */
    protected $isActive = false;

    /**
     * @var SecurityArea[]
     *
     * @ORM\ManyToMany(targetEntity="SecurityArea")
     * @ORM\JoinTable(name="ehdev_fwb_secarea2festival",
     *      joinColumns={@ORM\JoinColumn(name="festival_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="secare_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $securityAreas;

    /**
     * @var FestivalAccount|null
     * @ORM\ManyToOne(targetEntity="FestivalAccount", inversedBy="festivals",cascade={"persist"})
     * @ORM\JoinColumn(name="festival_account_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $festivalAccount;

    public function __construct()
    {
        parent::__construct();

        $this->securityAreas = [];
    }

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
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return self
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
     * @return self
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
     * @return self
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
     * @param \EHDev\FestivalBasicsBundle\Entity\Stage $stage
     */
    public function addStage(Stage $stage)
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
        }
    }

    /**
     * @param \EHDev\FestivalBasicsBundle\Entity\Stage $stage
     */
    public function removeStage(Stage $stage)
    {
        $this->stages->removeElement($stage);
    }

    /**
     * @return SecurityArea[]
     */
    public function getSecurityAreas()
    {
        return $this->securityAreas;
    }

    /**
     * @param SecurityArea[] $securityAreas
     */
    public function setSecurityAreas($securityAreas): Festival
    {
        $this->securityAreas = $securityAreas;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): Festival
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getFestivalAccount(): ?FestivalAccount
    {
        return $this->festivalAccount;
    }

    public function setFestivalAccount(FestivalAccount $festivalAccount): void
    {
        $this->festivalAccount = $festivalAccount;
    }
}
