<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendContactEmail;
use Oro\Bundle\EmailBundle\Entity\EmailInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;

/**
 * @ORM\Entity
 * @ORM\Table("ehdev_fwb_contact_email", indexes={
 *      @ORM\Index(name="primary_email_idx", columns={"email", "is_primary"})
 * })
 */
class ContactEmail extends ExtendContactEmail implements EmailInterface, DatesAwareInterface
{
    use DatesAwareTrait;

    public function __construct(?string $eMail = '')
    {
        parent::__construct($eMail);
    }

    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="emails")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $owner;

    public function getEmailField()
    {
        return 'email';
    }

    public function getEmailOwner(): Contact
    {
        return $this->getOwner();
    }

    public function setOwner(Contact $owner): void
    {
        $this->owner = $owner;
    }

    public function getOwner(): Contact
    {
        return $this->owner;
    }
}
