<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendSecurityArea;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-list-alt"},
 *  "tag"={"enabled"=true}
 * })
 */
#[ORM\Entity]
#[ORM\Table('ehdev_fwb_security_area')]
#[ORM\HasLifecycleCallbacks]
#[ORM\MappedSuperclass]
class SecurityArea extends ExtendSecurityArea implements \Stringable
{
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    protected string $name = '';

    #[ORM\Column(type: 'text', nullable: true)]
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
