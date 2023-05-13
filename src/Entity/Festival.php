<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityInterface;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityTrait;
use Oro\Bundle\OrganizationBundle\Entity\Ownership\BusinessUnitAwareTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="EHDev\FestivalBasicsBundle\Entity\Repository\FestivalRepository")
 * @ORM\Table(name="ehdev_fwb_festival")
 *
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
class Festival implements ExtendEntityInterface
{
    use BusinessUnitAwareTrait;
    use ExtendEntityTrait;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     */
    protected string $name = '';

    /**
     * @ORM\Column(type="datetime", name="start_date")
     *
     * @Assert\NotBlank()
     */
    protected ?\DateTime $startDate = null;

    /**
     * @ORM\Column(type="datetime", name="end_date")
     *
     * @Assert\NotBlank()
     */
    protected ?\DateTime $endDate = null;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotNull()
     */
    protected int $maxGuests = 0;

    /**
     * @ORM\OneToMany(
     *      targetEntity="EHDev\FestivalBasicsBundle\Entity\Stage", mappedBy="festival",
     *      cascade={"all"}, orphanRemoval=true
     * )
     */
    protected Collection $stages;

    /**
     * @ORM\Column(type="boolean", name="is_active")
     */
    protected bool $isActive = false;

    /**
     * @ORM\ManyToMany(targetEntity="SecurityArea")
     * @ORM\JoinTable(name="ehdev_fwb_secarea2festival",
     *      joinColumns={@ORM\JoinColumn(name="festival_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="secare_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected Collection $securityAreas;

    /**
     * @ORM\ManyToOne(targetEntity="FestivalAccount", inversedBy="festivals",cascade={"persist"})
     * @ORM\JoinColumn(name="festival_account_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected ?FestivalAccount $festivalAccount = null;

    public function __construct()
    {
        $this->securityAreas = new ArrayCollection();
        $this->stages = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getMaxGuests(): int
    {
        return $this->maxGuests;
    }

    public function setMaxGuests(int $maxGuests): self
    {
        $this->maxGuests = $maxGuests;

        return $this;
    }

    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): void
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
        }
    }

    public function removeStage(Stage $stage): void
    {
        $this->stages->removeElement($stage);
    }

    public function getSecurityAreas(): Collection
    {
        return $this->securityAreas;
    }

    public function setSecurityAreas(Collection $securityAreas): self
    {
        $this->securityAreas = $securityAreas;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
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
