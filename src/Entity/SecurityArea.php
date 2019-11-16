<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendSecurityArea;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;

/**
 * @ORM\Entity
 * @ORM\Table(name="ehdev_fwb_security_area")
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-list-alt"},
 *  "tag"={"enabled"=true}
 * })
 */
class SecurityArea extends ExtendSecurityArea
{
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name = '';

    /**
     * @var string|null
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): SecurityArea
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): SecurityArea
    {
        $this->description = $description;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
