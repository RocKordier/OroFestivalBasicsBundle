<?php

namespace EHDev\Bundle\FestivalBasicsBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\OroDateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FestivalType
 *
 * @package EHDev\Bundle\FestivalBasicsBundle\Form\Type
 */
class FestivalType extends AbstractType
{
    const LABEL_PREFIX = 'ehdev.festival.festival.';

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ehdev_festival';
    }

    /**
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
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
                    'label' => self::LABEL_PREFIX.'startDate.label',
                ]
            )
            ->add(
                'endDate',
                OroDateType::class,
                [
                    'label' => self::LABEL_PREFIX.'endDate.label',
                ]
            )
            ->add(
                'maxGuests',
                IntegerType::class,
                [
                    'label' => self::LABEL_PREFIX.'maxGuests.label',
                ]
            );
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'EHDev\Bundle\FestivalBasicsBundle\Entity\Festival',
            ]
        );
    }
}
