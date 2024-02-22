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
class UserType3 extends AbstractType
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
            ->add('firstName')
            ->add('lastName')
            ->add('phoneNumber')
            ->add('birthdate')
            ->add('address')
            ->add('speciality', ChoiceType::class, [
                'choices' => [
                    'Select a job' => '',
                    'Dentist' => 'Dentist',
                    'Gynecologist' => 'Gynecologist',
                    'Cardiologist' => 'Cardiologist',
                    'Orthopedic Surgeon' => 'Orthopedic Surgeon',
                    'Pediatrician' => 'Pediatrician',
                    'Neurologist' => 'Neurologist',
                    'Ophthalmologist' => 'Ophthalmologist',
                    'Psychiatrist' => 'Psychiatrist',
                    'Urologist' => 'Urologist',
                    'Endocrinologist' => 'Endocrinologist',
                    'Dermatologist' => 'Dermatologist',
                    'Oncologist' => 'Oncologist',
                    'ENT Specialist' => 'ENT Specialist',
                    'Rheumatologist' => 'Rheumatologist',
                    'Gastroenterologist' => 'Gastroenterologist',
                    'Hematologist' => 'Hematologist',
                    'Nephrologist' => 'Nephrologist',
                    'Pulmonologist' => 'Pulmonologist',
                    'Allergist/Immunologist' => 'Allergist/Immunologist',
                    'Emergency Medicine Physician' => 'Emergency Medicine Physician',
                    'Geriatrician' => 'Geriatrician',
                    'General Surgeon' => 'General Surgeon',
                    'Plastic Surgeon' => 'Plastic Surgeon',
                    'Sports Medicine Specialist' => 'Sports Medicine Specialist',
                    'Interventional Cardiologist' => 'Interventional Cardiologist',
                    'Obstetrician' => 'Obstetrician',
                    'Hospitalist' => 'Hospitalist',
                    'Maxillofacial Surgeon' => 'Maxillofacial Surgeon',
                    'Podiatrist' => 'Podiatrist',
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 0,
                    'Female' => 1,
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Gender',
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'col mt-2'],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
            ])
            ->add('pharmacytype', ChoiceType::class, [
                'choices' => [
                    'Day' => 0,
                    'Night' => 1,
                ],
                'label'=> 'work time',
                'expanded' => false,
                'multiple' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'col mt-2'],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
                
            ])
            ->add('public_or_private', ChoiceType::class, [
                'choices' => [
                    'public' => 0,
                    'private' => 1,
                ],
                'expanded' => false,
                'multiple' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'col mt-2'],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}