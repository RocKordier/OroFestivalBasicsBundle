<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\AddressBundle\Entity\AbstractEmail;
use Oro\Bundle\EmailBundle\Entity\EmailInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityInterface;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityTrait;

/**
 * @ORM\Entity
 * @ORM\Table("ehdev_fwb_contact_email", indexes={
 *      @ORM\Index(name="primary_email_idx", columns={"email", "is_primary"})
 * })
 */
class ContactEmail extends AbstractEmail implements ExtendEntityInterface, EmailInterface, DatesAwareInterface
{
    use DatesAwareTrait;
    use ExtendEntityTrait;

    public function __construct(?string $email = '')
    {
        parent::__construct($email);
    }

    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="emails")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected ?Contact $owner = null;

    public function getEmailField(): string
    {
        return 'email';
    }

    public function getEmailOwner(): ?Contact
    {
        return $this->getOwner();
    }

    public function setOwner(Contact $owner): void
    {
        $this->owner = $owner;
    }

    public function getOwner(): ?Contact
    {
        return $this->owner;
    }
}
