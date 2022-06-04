<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Form\DataObject\AddFestivalAccountDOT;
use Oro\Bundle\FormBundle\Form\Type\OroEntitySelectOrCreateInlineType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalAccountAddFestivalType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'ehdev_festival_festival_account_add_festival';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'festival',
            OroEntitySelectOrCreateInlineType::class,
            [
                'required' => true,
                'autocomplete_alias' => 'ehdev_festival',
                'create_enabled' => false,
                'grid_name' => 'ehdev-festival-festival-grid',
                'configs' => [
                    'placeholder' => 'ehdev.festivalbasics.festival.form.placeholder.choose',
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', AddFestivalAccountDOT::class);
    }
}
