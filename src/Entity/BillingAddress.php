<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EHDev\FestivalBasicsBundle\Model\ExtendBillingAddress;
use Oro\Bundle\AddressBundle\Entity\Country;
use Oro\Bundle\AddressBundle\Entity\Region;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\FormBundle\Entity\EmptyItem;

/**
 * @ORM\Table("ehdev_fwb_billing_address")
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *       defaultValues={
 *          "entity"={
 *              "icon"="fa-map-marker"
 *          }
 *      }
 * )
 * @ORM\Entity
 */
class BillingAddress extends ExtendBillingAddress implements DatesAwareInterface, EmptyItem
{
    use DatesAwareTrait;

    public function __construct(FestivalAccount $festivalAccount)
    {
        parent::__construct();

        $this->owner = $festivalAccount;
    }

    /**
     * @var FestivalAccount
     *
     * @ORM\OneToOne(targetEntity="FestivalAccount", inversedBy="billingAddress")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     */
    protected $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street", type="string", length=500, nullable=true)
     */
    protected $street;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street2", type="string", length=500, nullable=true)
     */
    protected $street2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postal_code", type="string", length=255, nullable=true)
     */
    protected $postalCode;

    /**
     * @var Country|null
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\AddressBundle\Entity\Country")
     * @ORM\JoinColumn(name="country_code", referencedColumnName="iso2_code")
     */
    protected $country;

    /**
     * @var Region|null
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\AddressBundle\Entity\Region")
     * @ORM\JoinColumn(name="region_code", referencedColumnName="combined_code")
     */
    protected $region;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region_text", type="string", length=255, nullable=true)
     */
    protected $regionText;

    /**
     * @var string|null
     *
     * @ORM\Column(name="organization", type="string", length=255, nullable=true)
     */
    protected $organization;

    public function setOwner(FestivalAccount $owner)
    {
        $this->owner = $owner;
    }

    public function getOwner(): FestivalAccount
    {
        return $this->owner;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    public function setStreet2(?string $street2): void
    {
        $this->street2 = $street2;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): void
    {
        $this->country = $country;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): void
    {
        $this->region = $region;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $organization): void
    {
        $this->organization = $organization;
    }

    public function getCountryName(): string
    {
        return $this->country ? $this->country->getName() : '';
    }

    public function getCountryIso3(): string
    {
        return $this->country ? $this->country->getIso3Code() : '';
    }

    public function getCountryIso2(): string
    {
        return $this->country ? $this->country->getIso2Code() : '';
    }
    
    public function getRegionText(): ?string
    {
        return $this->regionText;
    }
    
    public function setRegionText(?string $regionText): void
    {
        $this->regionText = $regionText;
    }

    public function __toString()
    {
        $region = $this->region ? $this->region->getName() : '';

        $data = [
            $this->getOrganization(),
            ',',
            $this->getStreet(),
            $this->getStreet2(),
            $this->getCity(),
            $region,
            ',',
            $this->getCountry(),
            $this->getPostalCode(),
        ];

        return trim(implode(' ', $data), " \t\n\r\0\x0B,");
    }

    public function isEmpty(): bool
    {
        return empty($this->label)
            && empty($this->street)
            && empty($this->street2)
            && empty($this->city)
            && empty($this->region)
            && empty($this->regionText)
            && empty($this->country)
            && empty($this->postalCode);
    }
}
