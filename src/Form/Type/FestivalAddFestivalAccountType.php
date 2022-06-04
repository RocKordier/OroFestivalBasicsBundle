<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Form\DataObject\AddFestivalAccountDOT;
use Oro\Bundle\FormBundle\Form\Type\OroEntitySelectOrCreateInlineType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalAddFestivalAccountType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'ehdev_festival_festival_add_festival_account';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'festivalAccount',
            OroEntitySelectOrCreateInlineType::class,
            [
                'required' => true,
                'autocomplete_alias' => 'ehdev_festival_account',
                'create_enabled' => false,
                'grid_name' => 'ehdev-festival-festival-account-grid',
                'configs' => [
                    'placeholder' => 'ehdev.festivalbasics.festivalaccount.form.placeholder.choose',
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', AddFestivalAccountDOT::class);
    }
}
