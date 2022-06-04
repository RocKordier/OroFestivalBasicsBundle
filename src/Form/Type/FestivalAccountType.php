<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use Oro\Bundle\UserBundle\Form\Type\UserSelectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalAccountType extends AbstractType
{
    public const LABEL_PREFIX = 'ehdev.festivalbasics.festivalaccount.';

    public function getBlockPrefix(): string
    {
        return 'ehdev_festival_account';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => self::LABEL_PREFIX.'name.label',
            ]
        );
        $builder->add(
            'accountManager',
            UserSelectType::class,
            [
                'label' => self::LABEL_PREFIX.'account_manager.label',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', FestivalAccount::class);
    }
}
