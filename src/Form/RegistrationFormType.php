<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('birthdate')
            ->add('phoneNumber')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 0,
                    'Female' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Gender',
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
class RegistrationForm2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('birthdate')
            ->add('phoneNumber')
            ->add('address')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 0,
                    'Female' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Gender',
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'col mt-2'],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
            ])
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
            ->add('certification', FileType::class, [
                'label' => 'Certification',
                'required' => True,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
class RegistrationForm3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('phoneNumber')
            ->add('address')
            ->add('pharmacytype', ChoiceType::class, [
                'choices' => [
                    'Day' => 0,
                    'Night' => 1,
                ],
                'label'=> 'work time',
                'expanded' => true,
                'multiple' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'col mt-2'],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
                
            ])
            ->add('certification', FileType::class, [
                'label' => 'Certification',
                'required' => True,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
class RegistrationForm4Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('phoneNumber')
            ->add('address')
            ->add('public_or_private', ChoiceType::class, [
                'choices' => [
                    'public' => 0,
                    'private' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'col mt-2'],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
                
            ])
            ->add('certification', FileType::class, [
                'label' => 'Certification',
                'required' => True,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

class RegistrationForm5Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('phoneNumber')
            ->add('address')
            ->add('public_or_private', ChoiceType::class, [
                'choices' => [
                    'public' => 0,
                    'private' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'col mt-2'],
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
            ])
            ->add('certification', FileType::class, [
                'label' => 'Certification',
                'required' => True,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}