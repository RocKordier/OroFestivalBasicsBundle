<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendContact;
use Oro\Bundle\EmailBundle\Entity\EmailOwnerInterface;
use Oro\Bundle\EmailBundle\Model\EmailHolderInterface;
use Oro\Bundle\EmailBundle\Model\EmailHolderNameInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\FormBundle\Entity\PrimaryItem;

/**
 * @ORM\Entity(repositoryClass="EHDev\FestivalBasicsBundle\Entity\Repository\ContactRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="ehdev_fwb_contact")
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-th-list"},
 *  "grid"={"default"="ehdev-festival-contact-grid"},
 *  "form"= {"grid_name"="ehdev-festival-contact-grid"},
 *  "tag"={"enabled"=true}
 * })
 */
class Contact extends ExtendContact implements DatesAwareInterface, EmailHolderInterface, EmailHolderNameInterface, EmailOwnerInterface, PrimaryItem
{
    use DatesAwareTrait;

    public function __construct(FestivalAccount $owner)
    {
        parent::__construct();

        $this->emails = new ArrayCollection();
        $this->owner = $owner;
    }

    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $firstName = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $lastName = '';

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $profession;

    /**
     * @var FestivalAccount
     *
     * @ORM\ManyToOne(targetEntity="FestivalAccount", inversedBy="contacts")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "contact_information"="email"
     *          }
     *      }
     * )
     */
    private $email;

    /**
     * @var ContactEmail[]|Collection
     *
     * @ORM\OneToMany(targetEntity="ContactEmail",
     *    mappedBy="owner", cascade={"all"}, orphanRemoval=true
     * )
     */
    private $emails;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_primary", type="boolean", nullable=true)
     */
    protected $primary = false;

    public function getId(): ?int
    {
        return $this->id;
    }

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
            //don't allow more than one primary email
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

    /**
     * @return Collection|ContactEmail[]
     */
    public function getEmails(): Collection
    {
        return $this->emails;
    }

    public function getEmail(): ?string
    {
        $primaryEmail = $this->getPrimaryEmail();
        if (!$primaryEmail) {
            return null;
        }

        return $primaryEmail->getEmail();
    }

    public function hasEmail(ContactEmail $email): bool
    {
        return $this->getEmails()->contains($email);
    }

    public function getPrimaryEmail(): ?ContactEmail
    {
        $result = null;

        foreach ($this->getEmails() as $email) {
            if ($email->isPrimary()) {
                $result = $email;
                break;
            }
        }

        return $result;
    }

    public function setPrimaryEmail(ContactEmail $email)
    {
        if ($this->hasEmail($email)) {
            $email->setPrimary(true);
            foreach ($this->getEmails() as $otherEmail) {
                if (!$email->isEqual($otherEmail)) {
                    $otherEmail->setPrimary(false);
                }
            }
        }
    }

    public function getClass()
    {
        return self::class;
    }

    public function getEmailFields()
    {
        return null;
    }

    public function isPrimary(): bool
    {
        return $this->primary;
    }

    public function setPrimary($primary)
    {
        $this->primary = $primary;
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
