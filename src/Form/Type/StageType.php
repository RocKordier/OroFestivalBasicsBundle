<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Entity\Stage;
use Oro\Bundle\FormBundle\Form\Type\OroEntitySelectOrCreateInlineType;
use Oro\Bundle\FormBundle\Form\Type\OroRichTextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public const LABEL_PREFIX = 'ehdev.festivalbasics.stage.';
    public const LABEL_PREFIX_FW = 'ehdev.festivalbasics.festival.';

    public function getBlockPrefix(): string
    {
        return 'ehdev_stage';
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
                'description',
                OroRichTextType::class,
                [
                    'label' => self::LABEL_PREFIX.'description.label',
                    'required' => false,
                ]
            )
            ->add(
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
        $resolver->setDefault('data_class', Stage::class);
    }
}
