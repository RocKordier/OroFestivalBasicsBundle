<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Entity\Repository\FestivalAccountRepository;
use EHDev\FestivalBasicsBundle\Model\ExtendFestivalAccount;
use Oro\Bundle\EntityBundle\EntityProperty\UpdatedByAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * @Config(defaultValues={
 *  "entity"={"icon"="fa-th-list"},
 *  "grid"={"default"="ehdev-festival-festival-account-grid"},
 *  "form"= {"grid_name"="ehdev-festival-festival-account-grid"},
 *  "security"={
 *      "type"="ACL",
 *      "group_name"="",
 *      "category"="ehdev_festival_festival"
 *  },
 *  "tag"={"enabled"=true}
 * })
 */
#[ORM\Entity(repositoryClass: FestivalAccountRepository::class)]
#[ORM\Table('ehdev_fwb_festival_account')]
#[ORM\UniqueConstraint(name: 'unq_festival_account_name', columns: ['name'])]
#[ORM\HasLifecycleCallbacks]
#[ORM\MappedSuperclass]
class FestivalAccount extends ExtendFestivalAccount
{
    public function __construct()
    {
        parent::__construct();

        $this->festivals = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    #[ORM\Column(type: 'string', length: 255)]
    protected string $name = '';

    #[ORM\OneToMany(targetEntity: Festival::class, mappedBy: 'festivalAccount')]
    protected Collection $festivals;

    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'owner')]
    protected Collection $contacts;

    #[ORM\OneToOne(targetEntity: BillingAddress::class, mappedBy: 'owner')]
    protected ?BillingAddress $billingAddress = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'account_manager_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    protected ?User $accountManager;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Festival[]|Collection
     */
    public function getFestivals(): Collection
    {
        return $this->festivals;
    }

    /**
     * @param Festival[]|Collection $festivals
     */
    public function setFestivals(Collection $festivals): void
    {
        $this->festivals = $festivals;
    }

    public function addFestival(Festival $festival): void
    {
        if (!$this->festivals->contains($festival)) {
            $this->festivals->add($festival);
            $festival->setFestivalAccount($this);
        }
    }

    public function getBillingAddress(): ?BillingAddress
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?BillingAddress $billingAddress): void
    {
        $this->billingAddress = $billingAddress;
    }

    public function getAccountManager(): ?User
    {
        return $this->accountManager;
    }

    public function setAccountManager(?User $accountManager): void
    {
        $this->accountManager = $accountManager;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    /**
     * @param Collection|Contact[] $contacts
     */
    public function setContacts(Collection $contacts): void
    {
        $this->contacts = $contacts;
    }
}
