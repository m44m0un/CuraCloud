<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Patient' => 'ROLE_PATIENT',
                    'Doctor' => 'ROLE_DOCTOR',
                    'Pharmacy' => 'ROLE_PHARMACY',
                    'Radiology' => 'ROLE_RADIOLOGY',
                    'Laboratory' => 'ROLE_LAB',
                ],
                'multiple' => true, // permet de sélectionner plusieurs rôles
                'expanded' => false, // affiche les rôles sous forme de cases à cocher
            ])
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('phoneNumber')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
