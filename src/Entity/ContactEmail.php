<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\BasicsBundle\Entity\Traits\CreatedUpdatedTrait;
use EHDev\FestivalBasicsBundle\Model\ExtendContactEmail;
use Oro\Bundle\EmailBundle\Entity\EmailInterface;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

#[ORM\Entity]
#[ORM\Table('ehdev_fwb_contact_email')]
#[ORM\Index(name: 'primary_email_idx', columns: ['email', 'is_primary'])]
#[ORM\HasLifecycleCallbacks]
#[ORM\MappedSuperclass]
class ContactEmail extends ExtendContactEmail implements EmailInterface
{
    use CreatedUpdatedTrait;

    #[ORM\Column('id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    protected $id;

    /**
     * @var string
     *
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "identity"=true
     *          },
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    #[ORM\Column(name: 'email', type: 'string', length: 255, nullable: false)]
    protected $email;

    /**
     * @var boolean|null
     */
    #[ORM\Column(name: 'is_primary', type: 'boolean', nullable: true)]
    protected $primary = null;

    public function __construct(?string $email = '')
    {
        parent::__construct($email);
    }

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'emails')]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
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
