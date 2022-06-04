<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use Oro\Bundle\FormBundle\Form\Type\OroDateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalType extends AbstractType
{
    public const LABEL_PREFIX = 'ehdev.festivalbasics.festival.';

    public function getBlockPrefix(): string
    {
        return 'ehdev_festival';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => self::LABEL_PREFIX.'name.label',
                ]
            )
            ->add(
                'startDate',
                OroDateType::class,
                [
                    'label' => self::LABEL_PREFIX.'start_date.label',
                ]
            )
            ->add(
                'endDate',
                OroDateType::class,
                [
                    'label' => self::LABEL_PREFIX.'end_date.label',
                ]
            )
            ->add(
                'maxGuests',
                IntegerType::class,
                [
                    'label' => self::LABEL_PREFIX.'max_guests.label',
                ]
            )
            ->add(
                'isActive',
                CheckboxType::class,
                [
                    'label' => self::LABEL_PREFIX.'is_active.label',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', Festival::class);
    }
}
