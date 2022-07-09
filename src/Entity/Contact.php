<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Entity\Repository\ContactRepository;
use EHDev\FestivalBasicsBundle\Model\ExtendContact;
use Oro\Bundle\EmailBundle\Entity\EmailOwnerInterface;
use Oro\Bundle\EmailBundle\Model\EmailHolderInterface;
use Oro\Bundle\EmailBundle\Model\EmailHolderNameInterface;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\FormBundle\Entity\PrimaryItem;

/**
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-th-list"},
 *  "grid"={"default"="ehdev-festival-contact-grid"},
 *  "form"= {"grid_name"="ehdev-festival-contact-grid"},
 *  "tag"={"enabled"=true}
 * })
 */
#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ORM\Table('ehdev_fwb_contact')]
#[ORM\HasLifecycleCallbacks]
#[ORM\MappedSuperclass]
class Contact extends ExtendContact implements EmailHolderInterface, EmailHolderNameInterface, EmailOwnerInterface, PrimaryItem
{
    public function __construct(FestivalAccount $owner)
    {
        parent::__construct();

        $this->emails = new ArrayCollection();
        $this->owner = $owner;
    }

    #[ORM\Column(name: 'first_name', type: 'string', length: 255)]
    protected string $firstName = '';

    #[ORM\Column(name: 'last_name', type: 'string', length: 255)]
    protected string $lastName = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected ?string $profession = null;

    #[ORM\ManyToOne(targetEntity: FestivalAccount::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected FestivalAccount $owner;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected ?string $email = null;

    #[ORM\OneToMany(targetEntity: ContactEmail::class, mappedBy: 'owner', cascade: ['all'], orphanRemoval: true)]
    protected Collection $emails;

    #[ORM\Column(type: 'boolean', name: 'is_primary')]
    protected bool $primary = false;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getOwner(): FestivalAccount
    {
        return $this->owner;
    }

    public function setOwner(FestivalAccount $owner): void
    {
        $this->owner = $owner;
    }

    public function getEmailHolderName(): string
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }

    public function addEmail(ContactEmail $email): void
    {
        if (!$this->emails->contains($email)) {
            // don't allow more than one primary email
            if ($email->isPrimary() && $this->getPrimaryEmail()) {
                $email->setPrimary(false);
            }

            $this->emails->add($email);
            $email->setOwner($this);
        }
    }

    public function removeEmail(ContactEmail $email): void
    {
        if ($this->emails->contains($email)) {
            $this->emails->removeElement($email);
        }
    }

    public function getEmails(): Collection
    {
        return $this->emails;
    }

    public function getEmail(): ?string
    {
        return $this->getPrimaryEmail()?->getEmail();
    }

    public function hasEmail(ContactEmail $email): bool
    {
        return $this->getEmails()->contains($email);
    }

    public function getPrimaryEmail(): ?ContactEmail
    {
        $result = null;

        /** @var ContactEmail $email */
        foreach ($this->getEmails() as $email) {
            if ($email->isPrimary()) {
                $result = $email;
                break;
            }
        }

        return $result;
    }

    public function setPrimaryEmail(ContactEmail $email): void
    {
        if ($this->hasEmail($email)) {
            $email->setPrimary(true);
            /** @var ContactEmail $otherEmail */
            foreach ($this->getEmails() as $otherEmail) {
                if (!$email->isEqual($otherEmail)) {
                    $otherEmail->setPrimary(false);
                }
            }
        }
    }

    public function getClass(): string
    {
        return self::class;
    }

    public function getEmailFields(): ?array
    {
        return null;
    }

    public function isPrimary(): bool
    {
        return $this->primary;
    }

    public function setPrimary($value): void
    {
        $this->primary = $value;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): void
    {
        $this->profession = $profession;
    }
}
