<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FestivalAddFestivalAccountType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'ehdev_festival_add_festival_account';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'festival_account',
            EntityType::class,
            [
                'class' => FestivalAccount::class,
                'required' => true,
                'mapped' => false,
            ]
        );
    }
}
