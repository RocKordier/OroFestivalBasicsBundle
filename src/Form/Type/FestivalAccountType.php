<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalAccountType extends AbstractType
{
    const LABEL_PREFIX = 'ehdev.festivalbasics.festivalaccount.';

    public function getBlockPrefix()
    {
        return 'ehdev_festival_account';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => self::LABEL_PREFIX.'name.label',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => FestivalAccount::class,
            ]
        );
    }
}
