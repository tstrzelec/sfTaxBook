<?php

namespace App\Form;

use App\Entity\UsersProfiles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street')
            ->add('houseNo')
            ->add('postalCode')
            ->add('city')
            ->add('country')
            ->add('nipNo')
            ->add('regon')
            ->add('bankName')
            ->add('bankAccountNumber');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UsersProfiles::class,
        ]);
    }
}
