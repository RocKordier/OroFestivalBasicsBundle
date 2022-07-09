<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Entity\Repository\FestivalRepository;
use EHDev\FestivalBasicsBundle\Model\ExtendFestival;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-th-list"},
 *  "grid"={"default"="ehdev-festival-festival-grid"},
 *  "form"= {"grid_name"="ehdev-festival-festival-grid"},
 *  "tag"={"enabled"=true},
 *  "security"={
 *      "type"="ACL",
 *      "group_name"="",
 *      "category"="ehdev_festival_festival"
 *  }
 * })
 */
#[ORM\Entity(repositoryClass: FestivalRepository::class)]
#[ORM\Table('ehdev_fwb_festival')]
#[ORM\HasLifecycleCallbacks]
#[ORM\MappedSuperclass]
class Festival extends ExtendFestival
{
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    protected string $name = '';

    #[Assert\NotBlank]
    #[ORM\Column(name: 'start_date', type: 'datetime', nullable: true)]
    protected ?\DateTime $startDate = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: 'end_date', type: 'datetime', nullable: true)]
    protected ?\DateTime $endDate = null;

    #[Assert\NotNull]
    #[ORM\Column(name: 'maxguests', type: 'integer')]
    protected int $maxGuests = 0;

    #[ORM\OneToMany(targetEntity: Stage::class, mappedBy: 'festival', cascade: ['all'], orphanRemoval: true)]
    protected Collection $stages;

    #[ORM\Column(type: 'boolean', name: 'is_active')]
    protected bool $isActive = false;

    #[ORM\ManyToMany(targetEntity: SecurityArea::class)]
    #[ORM\JoinTable(name: 'ehdev_fwb_secarea2festival')]
    #[ORM\JoinColumn(name: 'festival_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'secare_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected Collection $securityAreas;

    #[ORM\ManyToOne(targetEntity: FestivalAccount::class, inversedBy: 'festivals', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'festival_account_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    protected ?FestivalAccount $festivalAccount = null;

    public function __construct()
    {
        parent::__construct();

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
