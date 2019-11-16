<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Entity\Festival;
use EHDev\FestivalBasicsBundle\Entity\SecurityArea;
use Oro\Bundle\FormBundle\Form\Type\OroDateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalType extends AbstractType
{
    const LABEL_PREFIX = 'ehdev.festivalbasics.festival.';

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ehdev_festival';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Festival::class,
            ]
        );
    }
}
