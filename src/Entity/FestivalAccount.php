<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendFestivalAccount;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityBundle\EntityProperty\UpdatedByAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\OrganizationBundle\Entity\OrganizationAwareInterface;
use Oro\Bundle\OrganizationBundle\Entity\Ownership\BusinessUnitAwareTrait;

/**
 * @ORM\Entity(repositoryClass="EHDev\FestivalBasicsBundle\Entity\Repository\FestivalAccountRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="ehdev_fwb_festival_account",
 *  uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_festival_account_name", columns={"name"})
 *  }
 * )
 * @Config(
 *      defaultValues={
 *          "entity"={"icon"="fa-th-list"},
 *          "grid"={"default"="ehdev-festival-festival-account-grid"},
 *          "form"= {"grid_name"="ehdev-festival-festival-account-grid"},
 *          "ownership"={
 *              "owner_type"="USER",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="user_owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id"
 *          },
 *          "tag"={"enabled"=true}
 *      }
 * )
 */
class FestivalAccount extends ExtendFestivalAccount implements DatesAwareInterface, OrganizationAwareInterface
{
    use UpdatedByAwareTrait;
    use DatesAwareTrait;
    use BusinessUnitAwareTrait;

    public function __construct()
    {
        parent::__construct();

        $this->festivals = new ArrayCollection();
    }

    /**
     * @var integer|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name = '';

    /**
     * @var Festival[]|Collection
     *
     * @ORM\OneToMany(targetEntity="EHDev\FestivalBasicsBundle\Entity\Festival",
     *     mappedBy="festivalAccount"
     * )
     */
    protected $festivals;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
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

    /**
     * @param Festival $festival
     */
    public function addFestival(Festival $festival): void
    {
        if (!$this->festivals->contains($festival)) {
            $this->festivals->add($festival);
            $festival->setFestivalAccount($this);
        }
    }
}
