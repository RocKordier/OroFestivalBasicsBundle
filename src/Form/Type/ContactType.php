<?php

declare(strict_types=1);

namespace EHDev\FestivalBasicsBundle\Form\Type;

use EHDev\FestivalBasicsBundle\Entity\Contact;
use EHDev\FestivalBasicsBundle\Entity\ContactEmail;
use EHDev\FestivalBasicsBundle\Entity\FestivalAccount;
use Oro\Bundle\AddressBundle\Form\Type\EmailCollectionType;
use Oro\Bundle\AddressBundle\Form\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    const LABEL_PREFIX = 'ehdev.festivalbasics.contact.';

    public function getBlockPrefix()
    {
        return 'ehdev_festival_account';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
            'firstName',
            TextType::class,
            [
                'label' => self::LABEL_PREFIX.'first_name.label',
            ]
        );
        $builder->add(
            'lastName',
            TextType::class,
            [
                'label' => self::LABEL_PREFIX.'last_name.label',
            ]
        );
        $builder->add(
            'profession',
            TextType::class,
            [
                'label' => self::LABEL_PREFIX.'profession.label',
            ]
        );

        $builder->add(
            'emails',
            EmailCollectionType::class,
            [
                'label' => self::LABEL_PREFIX.'emails.label',
                'entry_type' => EmailType::class,
                'required' => false,
                'entry_options' => [
                    'data_class' => ContactEmail::class,
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Contact::class,
            ]
        );
    }
}
