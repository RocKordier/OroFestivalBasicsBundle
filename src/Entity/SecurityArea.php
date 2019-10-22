<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendSecurityArea;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     */
    private $name = '';

    /**
     * @var string|null
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return SecurityArea
     */
    public function setName($name): SecurityArea
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return SecurityArea
     */
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
