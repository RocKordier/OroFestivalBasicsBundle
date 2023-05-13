<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Entity\BillingAddress;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use Oro\Bundle\AddressBundle\Form\EventListener\AddressCountryAndRegionSubscriber;
use Oro\Bundle\AddressBundle\Form\Type\CountryType;
use Oro\Bundle\AddressBundle\Form\Type\RegionType;
use Oro\Bundle\FormBundle\Form\Extension\StripTagsExtension;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingAddressType extends AbstractType
{
    public const LABEL_PREFIX = 'ehdev.festivalbasics.billingaddress.';

    public function __construct(
        private readonly AddressCountryAndRegionSubscriber $eventListener
    ) {}

    public function getBlockPrefix(): string
    {
        return 'ehdev_festival_billingaddress';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventSubscriber($this->eventListener);

        $builder->add(
            'owner',
            EntityType::class,
            [
                'class' => FestivalAccount::class,
                'choice_label' => 'name',
                'disabled' => true,
            ]
        );
        $builder->add(
            'label',
            TextType::class,
            [
                'required' => false,
                'label' => 'oro.address.label.label',
                StripTagsExtension::OPTION_NAME => true,
            ]
        );
        $builder->add(
            'organization',
            TextType::class,
            [
                'required' => false,
                'label' => 'oro.address.organization.label',
                StripTagsExtension::OPTION_NAME => true,
            ]
        );
        $builder->add(
            'street',
            TextType::class,
            [
                'required' => false,
                'label' => 'oro.address.street.label',
                StripTagsExtension::OPTION_NAME => true,
            ]
        );
        $builder->add(
            'street2',
            TextType::class,
            [
                'required' => false,
                'label' => 'oro.address.street2.label',
                StripTagsExtension::OPTION_NAME => true,
            ]
        );
        $builder->add(
            'postalCode',
            TextType::class,
            [
                'required' => false,
                'label' => 'oro.address.postal_code.label',
                StripTagsExtension::OPTION_NAME => true,
            ]
        );
        $builder->add(
            'city',
            TextType::class,
            [
                'required' => false,
                'label' => 'oro.address.city.label',
                StripTagsExtension::OPTION_NAME => true,
            ]
        );
        $builder->add(
            'country',
            CountryType::class,
            [
                'required' => true,
                'label' => 'oro.address.country.label',
            ]
        );
        $builder->add(
            'region',
            RegionType::class,
            [
                'required' => false,
                'label' => 'oro.address.region.label',
            ]
        );
        $builder->add(
            'region_text',
            HiddenType::class,
            [
                'required' => false,
                'random_id' => true,
                'label' => 'oro.address.region_text.label',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', BillingAddress::class);
        $resolver->setDefault('region_route', 'oro_api_country_get_regions');
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (!empty($options['region_route'])) {
            $view->vars['region_route'] = $options['region_route'];
        }
    }
}
