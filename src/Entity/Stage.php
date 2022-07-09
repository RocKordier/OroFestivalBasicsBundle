<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Entity\Repository\StageRepository;
use EHDev\FestivalBasicsBundle\Model\ExtendStage;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-flask"},
 *  "grid"={"default"="ehdev-festival-stage-grid"},
 *  "tag"={"enabled"=true},
 *  "security"={
 *      "type"="ACL",
 *      "group_name"="",
 *      "category"="ehdev_festival_stage"
 *  }
 * })
 */
#[ORM\Entity(repositoryClass: StageRepository::class)]
#[ORM\Table('ehdev_fwb_stage')]
#[ORM\HasLifecycleCallbacks]
#[ORM\MappedSuperclass]
class Stage extends ExtendStage
{
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    protected string $name = '';

    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $description = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'stages')]
    #[ORM\JoinColumn(name: 'festival_id', referencedColumnName: 'id')]
    protected ?Festival $festival = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(Festival $festival): self
    {
        $this->festival = $festival;

        return $this;
    }
}
