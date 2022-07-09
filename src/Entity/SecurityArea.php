<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\BasicsBundle\Entity\Traits\CreatedUpdatedTrait;
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
class SecurityArea extends ExtendSecurityArea implements \Stringable
{
    use CreatedUpdatedTrait;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected string $name = '';

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected ?string $description;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): SecurityArea
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
